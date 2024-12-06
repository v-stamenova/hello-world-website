<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Enums\Status;
use App\Models\Partner;
use App\Services\PartnerService;
use App\Traits\FileValidation;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;
    use WithFileUploads;
    use FileValidation;

    /**
     * @availableStatuses string[]
     */
    public $availableStatuses = [];

    public string $name;
    public string $description;
    public string $website;
    public string $type;

    public string $email;
    public string $phone_number;
    public string $contact_person;
    public string $status;
    public $logo;
    public $logo_path;
    public bool $createIsOpen = false;
    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void {
        $this->partnerService = $partnerService;
    }

    public function mount(): void {
        $this->availableStatuses = array_map(
            fn($case) => [
                'display' => ucfirst($case->value),
                'value' => $case->value,
            ],
            Status::cases()
        );
    }

    public function save() : void {
        $data = $this->validate(
            array_merge(
                Partner::validationRulesCreation(),
                [
                    'logo' => [
                        'image',
                        'max:10240',
                    ]
                ]
            ),
            [
                'logo.max' => 'The file must not be larger than 10MB',
            ]
        );

        try {
            $this->validateFileNameLength($this->logo, 'logo');
            $this->logo_path = $this->logo->store('logos', 'public');

            $this->partnerService->createPartner(array_merge($data, ['logo_path' => $this->logo_path]));
            $this->cleanUp();
        } catch (Exception $exception) {
            $this->error(
                title: 'Oops! An error occurred',
                description: substr($exception->getMessage(), 0, 100) . '...'
            );
        }
    }

    public function cleanUp() : void {
        $this->dispatch("update-partners-list");
        $this->reset();
        $this->createIsOpen = false;
        $this->toast(
            type: 'success',
            title: 'Partner added!',
            icon: 'o-check-circle',
            css: 'text-sm bg-green-50 border border-green-800 text-green-800 shadow-sm',
        );
    }

    public function render()
    {
        return view('livewire.pages.internal.partner.create');
    }
}
