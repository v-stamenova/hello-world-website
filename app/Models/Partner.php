<?php

namespace App\Models;

use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'website', 'type', 'email', 'phone_number', 'contact_person'];

    public static function validationRulesCreation(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'description' => 'required|string|max:1000',
            'website' => 'required|regex:/^www\.[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255',
            'type' => 'required|string',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|regex:/^\+?[0-9]{11,14}$/',
            'contact_person' => 'nullable|string|max:255|regex:/^[\pL\s\-]+$/u',
        ];
    }

    public static function validationRulesUpdate(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'description' => 'required|string|max:1000',
            'website' => 'required|regex:/^www\.[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255',
            'type' => 'required|string',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|regex:/^\+?[0-9]{11,14}$/',
            'contact_person' => 'nullable|string|max:255|regex:/^[\pL\s\-]+$/u',
            'bla' => 'required'
        ];
    }
}
