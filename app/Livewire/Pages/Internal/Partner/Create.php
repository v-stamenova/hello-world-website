<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Models\Partner;
use App\Services\PartnerService;
use Exception;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public string $name;
    public string $description;
    public string $website;
    public string $type;

    public string $email;
    public string $phone_number;
    public string $contact_person;
    public bool $createIsOpen = false;
    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService) {
        $this->partnerService = $partnerService;
    }

    public function save() : void {
        $data = $this->validate(Partner::validationRulesCreation());

        try {
            $this->partnerService->createPartner($data);
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
