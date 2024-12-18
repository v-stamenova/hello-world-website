<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PartnerService
{
    /**
     * @param array{column: string, direction: string}|null $sortBy
     * @return Collection<int, Partner>
     */
    public function getPartnersSortedAndFiltered(?array $sortBy = null, string $filter = ''): Collection
    {
        return Partner::query()
            ->when($filter, fn(Builder $query) => $query->where('name', 'like', "%$filter%"))
            ->when(
                $sortBy !== null, // @phpstan-ignore-next-line false positive
                fn(Builder $query) => $query->orderBy($sortBy['column'], $sortBy['direction']),
                fn(Builder $query) => $query->orderBy('created_at', 'desc')
            )
            ->get();
    }

    /**
     * @param non-empty-array<string, mixed> $data
     */
    public function createPartner(array $data): Partner
    {
        $validator = Validator::make($data, Partner::validationRulesCreation());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Partner::create($validator->validated());
    }

    public function getPartner(int $partnerId): Partner {
        return Partner::findOrFail($partnerId);
    }

    /**
     * @param non-empty-array<string, mixed> $data
     */
    public function updatePartner(int $partnerId, array $data): bool
    {
        $validator = Validator::make($data, Partner::validationRulesUpdate());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $partner = $this->getPartner($partnerId);

        return $partner->update($validator->validated());
    }

    public function deletePartner(int $partnerId): bool
    {
        return Partner::query()->findOrFail($partnerId)->delete() ?? false;
    }
}
