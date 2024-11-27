<?php

namespace App\Services;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PartnerService
{
    /**
     * @param array $sortBy The columns to sort by.
     * @return Collection
     */
    public function getPartnersSorted(array $sortBy = []): Collection
    {
        return Partner::query()
            ->orderBy(...array_values($sortBy))
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
}
