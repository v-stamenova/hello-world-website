<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Enums\EnumHelper;
use App\Models\Partner;
use App\Services\PartnerService;
use App\Traits\FileValidation;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

#[On('open-create')]
#[On('close-create')]
class Create extends Component
{
    use Toast;
    use WithFileUploads;
    use FileValidation;

    /**
     * @availableStatuses string[]
     */
    public array $availableStatuses = [];
    public string $contact_person;
    public string $description;
    public string $email;
    public ?TemporaryUploadedFile $logo = null;
    public ?string $logo_path = '';
    public string $name;
    public string $phone_number;
    public string $status;
    public string $type;
    public string $website;

    public bool $createIsOpen = false;
    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void {
        $this->partnerService = $partnerService;
    }

    #[On('open-create')]
    public function setUpModal()
    {
        $this->logo = null;
        $this->logo_path = null;
        $this->dispatch('$refresh');

        $this->availableStatuses = EnumHelper::getStatuses();
        $this->createIsOpen = true;
    }

    public function save() : void {
        $data = $this->validate(
            array_merge(
                Partner::validationRulesCreation(),
                [
                    'logo' => [
                        'nullable',
                        'image',
                        'max:10240',
                    ]
                ]
            ),
            [
                'logo.max' => 'The file must not be larger than 10MB',
            ]
        );

        $this->logo_path = '';
        $this->dispatch('close-create');

        try {
            if($this->logo) {
                $this->validateFileNameLength($this->logo, 'logo');
                $this->logo_path = $this->logo->store('logos', 'public');
            }

            $this->partnerService->createPartner(array_merge($data, ['logo_path' => $this->logo_path]));
            $this->cleanUpSuccessfully();
        } catch (Exception $exception) {
            $this->error(
                title: 'Oops! An error occurred',
                description: substr($exception->getMessage(), 0, 100) . '...'
            );
        }
    }

    public function cleanUpSuccessfully() : void {
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

    public function close() : void {
        $this->reset();
        $this->createIsOpen = false;
        $this->dispatch("close-create");
    }

    public function render()
    {
        return view('livewire.pages.internal.partner.create');
    }
}
