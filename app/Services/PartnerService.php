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
     * @param array $sortBy The columns to sort by.
     * @return Collection<Partner>
     */
    public function getPartnersSortedAndFiltered(array $sortBy = [], string $filter = ''): Collection
    {
        return Partner::query()
            ->when($filter, fn(Builder $query) => $query->where('name', 'like', "%$filter%"))
            ->when(
                !empty($sortBy),
                fn(Builder $query) => $query->orderBy(...array_values($sortBy)),
                fn(Builder $query) => $query->orderBy('created_at', 'desc')
            )
            ->get();
    }

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
        return Partner::query()->findOrFail($partnerId)->delete();
    }
}
