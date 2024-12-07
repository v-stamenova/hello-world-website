<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Enums\EnumHelper;
use App\Enums\Status;
use App\Models\Partner;
use App\Services\PartnerService;
use App\Traits\FileValidation;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

#[On('edit-opened')]
class Edit extends Component
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
    public string $logo_path = '';
    public string $name;
    public string $phone_number;
    public string $status;
    public string $type;
    public string $website;
    public bool $isEditOpen = false;

    public Partner $partner;
    public int $partnerId;
    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void {
        $this->partnerService = $partnerService;
    }

    public function save() : void {
        $data = $this->validate(
            array_merge(
                Partner::validationRulesUpdate(),
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

        try {
            if($this->logo) {
                $this->validateFileNameLength($this->logo, 'logo');
                $this->logo_path = $this->logo->store('logos', 'public');
            }

            $this->partnerService->updatePartner($this->partnerId, array_merge($data, ['logo_path' => $this->logo_path]));
            $this->cleanUpSuccessfully();
        } catch (Exception $exception) {
            $this->error(
                title: 'Oops! An error occurred',
                description: substr($exception->getMessage(), 0, 100) . '...'
            );
        }
    }

    #[On('open-edit')]
    public function setUpModal(int $partnerId) {
        $this->reset();

        $this->partnerId = $partnerId;
        $this->partner = $this->partnerService->getPartner($partnerId);
        $this->availableStatuses = EnumHelper::getStatuses();

        $this->name = $this->partner->name;
        $this->description = $this->partner->description ?? '';
        $this->website = $this->partner->website ?? '';
        $this->type = $this->partner->type ?? '';
        $this->email = $this->partner->email ?? '';
        $this->phone_number = $this->partner->phone_number ?? '';
        $this->contact_person = $this->partner->contact_person ?? '';
        $this->status = $this->partner->status ?? '';
        $this->logo_path = $this->partner->logo_path ?? '';

        $this->isEditOpen = true;
        $this->dispatch('edit-opened');
    }

    public function close() : void {
        $this->isEditOpen = false;
        $this->reset();
        $this->render();
    }

    public function cleanUpSuccessfully() : void {
        $this->dispatch("update-partners-list");
        $this->reset();
        $this->isEditOpen = false;
        $this->render();
        $this->toast(
            type: 'success',
            title: 'Partner updated!',
            icon: 'o-check-circle',
            css: 'text-sm bg-green-50 border border-green-800 text-green-800 shadow-sm',
        );
    }
    public function render()
    {
        return view('livewire.pages.internal.partner.edit');
    }
}
