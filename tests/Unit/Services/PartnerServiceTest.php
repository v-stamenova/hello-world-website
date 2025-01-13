<?php

namespace Tests\Unit\Services;

use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PartnerServiceTest extends TestCase
{
    use RefreshDatabase;

    private PartnerService $partnerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->partnerService = App::make('App\Services\PartnerService');
    }

    #[Test]
    public function test_get_partners_sorted_and_filtered()
    {
        Partner::factory()->count(1)->create(['name' => 'Alpha']);
        Partner::factory()->count(1)->create(['name' => 'Algae']);
        Partner::factory()->count(1)->create(['name' => 'Gamma']);

        $sortBy = ['column' => 'name', 'direction' => 'asc'];
        $filter = 'Al';

        $result = $this->partnerService->getPartnersSortedAndFiltered($sortBy, $filter);

        $this->assertCount(2, $result);
        $sortedNames = $result->pluck('name')->toArray();
        $this->assertEquals(['Algae', 'Alpha'], $sortedNames);
    }

    #[Test]
    public function test_get_partners_sorted_and_filtered_with_filter_without_sort()
    {
        Partner::factory()->count(1)->create(['name' => 'Alpha']);
        Partner::factory()->count(1)->create(['name' => 'Beta']);
        Partner::factory()->count(1)->create(['name' => 'Gamma']);

        $filter = 'Alpha';

        $result = $this->partnerService->getPartnersSortedAndFiltered(filter: $filter);

        $this->assertCount(1, $result);
        $this->assertEquals('Alpha', $result->first()->name);
    }

    #[Test]
    public function test_get_partners_sorted_and_filtered_without_filter()
    {
        Partner::factory()->count(1)->create(['name' => 'Alpha']);
        Partner::factory()->count(1)->create(['name' => 'Beta']);
        Partner::factory()->count(1)->create(['name' => 'Gamma']);

        $sortBy = ['column' => 'name', 'direction' => 'asc'];

        $result = $this->partnerService->getPartnersSortedAndFiltered($sortBy);

        $this->assertCount(3, $result);
        $sortedNames = $result->pluck('name')->toArray();
        $this->assertEquals(['Alpha', 'Beta', 'Gamma'], $sortedNames);
    }

    #[Test]
    public function test_create_partner_successfully_with_all_details()
    {
        $data = [
            'name' => 'Example Partner Name',
            'description' => 'This is a valid description for the partner.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $partner = null;

        try {
            $partner = $this->partnerService->createPartner($data);
        } catch (ValidationException $e) {
            $this->fail('ValidationException thrown: '.$e->getMessage());
        }

        $this->assertNotNull($partner, 'Partner should not be null.');
        $this->assertInstanceOf(Partner::class, $partner, 'Created object should be an instance of Partner.');
        $this->assertEquals(1, Partner::all()->count());
        $this->assertEquals($data['name'], $partner->name);
        $this->assertEquals($data['description'], $partner->description);
        $this->assertEquals($data['website'], $partner->website);
        $this->assertEquals($data['type'], $partner->type);
        $this->assertEquals($data['email'], $partner->email);
        $this->assertEquals($data['phone_number'], $partner->phone_number);
        $this->assertEquals($data['contact_person'], $partner->contact_person);
        $this->assertEquals($data['status'], $partner->status);
    }

    #[Test]
    public function test_create_partner_successfully_with_only_required_details()
    {
        $data = [
            'name' => 'Example Partner Name',
            'description' => 'This is a valid description for the partner.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'status' => 'draft',
        ];

        $partner = null;

        try {
            $partner = $this->partnerService->createPartner($data);
        } catch (ValidationException $e) {
            $this->fail('ValidationException thrown: '.$e->getMessage());
        }

        $this->assertNotNull($partner, 'Partner should not be null.');
        $this->assertInstanceOf(Partner::class, $partner, 'Created object should be an instance of Partner.');
        $this->assertEquals(1, Partner::all()->count());
        $this->assertEquals($data['name'], $partner->name);
        $this->assertEquals($data['description'], $partner->description);
        $this->assertEquals($data['website'], $partner->website);
        $this->assertEquals($data['type'], $partner->type);
        $this->assertEquals($data['email'], $partner->email);
        $this->assertNull($partner->phone_number);
        $this->assertNull($partner->contact_person);
        $this->assertEquals($data['status'], $partner->status);
    }

    #[Test]
    public function test_create_partner_fails_when_name_is_invalid()
    {
        $data = [
            'name' => '',
            'description' => 'This is a valid description for the partner.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field is required.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_create_partner_fails_when_description_is_invalid()
    {
        $data = [
            'name' => 'Valid Name',
            'description' => '',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The description field is required.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_create_partner_fails_when_website_is_invalid()
    {
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'invalidwebsite.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The website field format is invalid.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_create_partner_fails_when_email_is_invalid()
    {
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'invalid-email',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email field must be a valid email address.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_create_partner_fails_when_phone_number_is_invalid()
    {
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '12345',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The phone number field format is invalid.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_create_partner_fails_when_status_is_invalid()
    {
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'invalid_status',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected status is invalid.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_create_partner_fails_when_logo_path_is_invalid()
    {
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => config('app.fallback_image_url'),
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected logo path is invalid.');

        $this->partnerService->createPartner($data);
    }

    #[Test]
    public function test_get_partner_successfully()
    {
        $partners = Partner::factory(1)->create();

        $foundPartner = $this->partnerService->getPartner($partners[0]->id);

        $this->assertNotNull($foundPartner, 'Partner should not be null.');
        $this->assertInstanceOf(Partner::class, $foundPartner, 'Created object should be an instance of Partner.');
        $this->assertEquals($partners[0]->toArray(), $foundPartner->toArray(), 'Partner attributes should match.');
    }

    #[Test]
    public function test_get_partner_fails_when_id_is_invalid()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->partnerService->getPartner(3);
    }

    #[Test]
    public function test_update_partner_successfully_with_all_details()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Example Partner Name',
            'description' => 'This is a valid description for the partner.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $isUpdated = null;

        try {
            $isUpdated = $this->partnerService->updatePartner($partners[0]->id, $data);
        } catch (ValidationException $e) {
            $this->fail('ValidationException thrown: '.$e->getMessage());
        }

        $partner = Partner::findOrFail($partners[0]->id);

        $this->assertTrue($isUpdated);
        $this->assertEquals(1, Partner::all()->count());
        $this->assertEquals($data['name'], $partner->name);
        $this->assertEquals($data['description'], $partner->description);
        $this->assertEquals($data['website'], $partner->website);
        $this->assertEquals($data['type'], $partner->type);
        $this->assertEquals($data['email'], $partner->email);
        $this->assertEquals($data['phone_number'], $partner->phone_number);
        $this->assertEquals($data['contact_person'], $partner->contact_person);
        $this->assertEquals($data['status'], $partner->status);
    }

    #[Test]
    public function test_update_partner_fails_when_name_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => '',
            'description' => 'This is a valid description for the partner.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The name field is required.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_update_partner_fails_when_description_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Valid Name',
            'description' => '',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The description field is required.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_update_partner_fails_when_website_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'invalidwebsite.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The website field format is invalid.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_update_partner_fails_when_email_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'invalid-email',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The email field must be a valid email address.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_update_partner_fails_when_phone_number_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '12345',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The phone number field format is invalid.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_update_partner_fails_when_status_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'invalid_status',
            'logo_path' => 'www.example.com/logo.png',
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected status is invalid.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_update_partner_fails_when_logo_path_is_invalid()
    {
        $partners = Partner::factory(1)->create();
        $data = [
            'name' => 'Valid Name',
            'description' => 'Valid description.',
            'website' => 'www.example.com',
            'type' => 'Business',
            'email' => 'partner@example.com',
            'phone_number' => '+12345678901',
            'contact_person' => 'John Doe',
            'status' => 'draft',
            'logo_path' => config('app.fallback_image_url'),
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The selected logo path is invalid.');

        $this->partnerService->updatePartner($partners[0]->id, $data);
    }

    #[Test]
    public function test_delete_partner_successfully()
    {
        $partners = Partner::factory(1)->create();

        $isDeleted = $this->partnerService->deletePartner($partners[0]->id);

        $this->assertTrue($isDeleted);
        $this->assertEquals(0, Partner::all()->count());
    }

    #[Test]
    public function test_delete_partner_fails_when_id_is_invalid()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->partnerService->getPartner(3);
    }
}
