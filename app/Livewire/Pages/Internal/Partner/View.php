<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Models\Partner;
use App\Services\PartnerService;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('open-view')]
class View extends Component
{
    public bool $viewIsOpen = false;
    public int $partnerId;
    public Partner $partner;
    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void{
        $this->partnerService = $partnerService;
    }

    #[On('open-view')]
    public function setUpModal(int $partnerId) {
        $this->reset();
        $this->partnerId = $partnerId;
        $this->partner = $this->partnerService->getPartner($partnerId);
        $this->viewIsOpen = true;
    }

    public function close() : void {
        $this->viewIsOpen = false;
        $this->reset();
        $this->render();
    }

    public function render()
    {
        return view('livewire.pages.internal.partner.view');
    }
}
