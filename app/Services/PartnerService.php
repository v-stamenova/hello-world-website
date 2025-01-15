<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PartnerService
{
    /**
     * @param  array{column: string, direction: string}|null  $sortBy
     * @return Collection<int, Partner>
     */
    public function getPartnersSortedAndFiltered(?array $sortBy = null, string $filter = ''): Collection
    {
        return Partner::query()
            ->when($filter, fn (Builder $query) => $query->where('name', 'like', "%$filter%"))
            ->when(
                $sortBy !== null, // @phpstan-ignore-next-line false positive
                fn (Builder $query) => $query->orderBy($sortBy['column'], $sortBy['direction']),
                fn (Builder $query) => $query->orderBy('created_at', 'desc')
            )
            ->get();
    }

    /**
     * @param  non-empty-array<string, mixed>  $data
     */
    public function createPartner(array $data): Partner
    {
        $validator = Validator::make($data, Partner::validationRulesCreation());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (!Auth::user()->can('create', Partner::class)) {
            throw new AuthorizationException();
        }

        return Partner::create($validator->validated());
    }

    public function getPartner(int $partnerId): Partner
    {
        return Partner::findOrFail($partnerId);
    }

    /**
     * @param non-empty-array<string, mixed> $data
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function updatePartner(int $partnerId, array $data): bool
    {
        $validator = Validator::make($data, Partner::validationRulesUpdate());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $partner = $this->getPartner($partnerId);
        if (!Auth::user()->can('update', $partner)){
            throw new AuthorizationException();
        }

        return $partner->update($validator->validated());
    }

    public function deletePartner(int $partnerId): bool
    {
        $partner = $this->getPartner($partnerId);
        if (!Auth::user()->can('delete', $partner)){
            throw new AuthorizationException();
        }

        return $partner->delete() ?? false;
    }
}
