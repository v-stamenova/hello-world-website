<?php

namespace App\Models;

use App\Enums\Status;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $website
 * @property string $email
 * @property string $type
 * @property string|null $contact_person
 * @property string|null $phone_number
 * @property string|null $logo_path
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static PartnerFactory factory($count = null, $state = [])
 * @method static Builder<static>|Partner newModelQuery()
 * @method static Builder<static>|Partner newQuery()
 * @method static Builder<static>|Partner query()
 * @method static Builder<static>|Partner whereContactPerson($value)
 * @method static Builder<static>|Partner whereCreatedAt($value)
 * @method static Builder<static>|Partner whereDeletedAt($value)
 * @method static Builder<static>|Partner whereDescription($value)
 * @method static Builder<static>|Partner whereEmail($value)
 * @method static Builder<static>|Partner whereId($value)
 * @method static Builder<static>|Partner whereLogoPath($value)
 * @method static Builder<static>|Partner whereName($value)
 * @method static Builder<static>|Partner whereType($value)
 * @method static Builder<static>|Partner whereUpdatedAt($value)
 * @method static Builder<static>|Partner whereWebsite($value)
 * @method static Builder<static>|Partner whereStatus($value)
 *
 * @property string|null $deleted_at
 *
 * @method static Builder<static>|Partner wherePhoneNumber($value)
 *
 * @mixin \Eloquent
 */
class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'website', 'type', 'email', 'phone_number', 'contact_person', 'status', 'logo_path'];

    /**
     * @return array<string, string|array<int, string|Rule>>
     */
    public static function validationRulesCreation(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[\pL\s\-.]+$/u',
            'description' => 'required|string|max:1000',
            'website' => 'required|regex:/^www\.[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/|max:255',
            'type' => 'required|string',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|regex:/^\+?[0-9]{11,14}$/',
            'contact_person' => 'nullable|string|max:255|regex:/^[\pL\s\-.]+$/u',
            'status' => 'required|string|in:'.implode(',', array_map(fn ($case) => $case->value, Status::cases())),
            'logo_path' => ['nullable', 'string', 'max:255', Rule::notIn([config('app.fallback_image_url')])],
        ];
    }

    /**
     * @return array<string, string|array<int, string|Rule>>
     */
    public static function validationRulesUpdate(): array
    {
        return Partner::validationRulesCreation();
    }
}
