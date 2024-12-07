<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Enums\EnumHelper;
use App\Models\Partner;
use App\Services\PartnerService;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public bool $deleteIsOpen = false;
    public int $partnerId;
    public Partner $partner;
    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void{
        $this->partnerService = $partnerService;
    }

    #[On('open-delete')]
    public function setUpModal(int $partnerId) {
        $this->reset();
        $this->partnerId = $partnerId;
        $this->partner = $this->partnerService->getPartner($partnerId);
        $this->deleteIsOpen = true;
    }

    public function confirm() {
        try {
            $this->partnerService->deletePartner($this->partnerId);
            $this->cleanUpSuccessfully();
        } catch (Exception $exception) {
            $this->error(
                title: 'Oops! An error occurred',
                description: substr($exception->getMessage(), 0, 100) . '...'
            );
        }
    }

    public function close() : void {
        $this->deleteIsOpen = false;
        $this->reset();
        $this->render();
    }

    public function cleanUpSuccessfully() : void {
        $this->dispatch("update-partners-list");
        $this->reset();
        $this->deleteIsOpen = false;
        $this->render();
        $this->toast(
            type: 'success',
            title: 'Partner deleted!',
            icon: 'o-check-circle',
            css: 'text-sm bg-green-50 border border-green-800 text-green-800 shadow-sm',
        );
    }

    public function render()
    {
        return view('livewire.pages.internal.partner.delete');
    }
}
