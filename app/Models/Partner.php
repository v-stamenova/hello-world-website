<?php

namespace App\Models;

use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $website
 * @property string $email
 * @property string $type
 * @property string|null $contact_person
 * @property string|null $phone_number
 * @property string|null $logo_path
 * @property string|null $dark_logo_path
 * @property string|null $postcode
 * @property string|null $street
 * @property string|null $house_number
 * @property string|null $city
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PartnerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDarkLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereWebsite($value)
 * @mixin \Eloquent
 */
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
