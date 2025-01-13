<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('open-view')]
class View extends Component
{
    public bool $viewIsOpen = false;

    public int $partnerId;

    public Partner $partner;

    private PartnerService $partnerService;

    public function boot(PartnerService $partnerService): void
    {
        $this->partnerService = $partnerService;
    }

    #[On('open-view')]
    public function setUpModal(int $partnerId): void
    {
        $this->reset();
        $this->partnerId = $partnerId;
        $this->partner = $this->partnerService->getPartner($partnerId);
        $this->viewIsOpen = true;
    }

    public function close(): void
    {
        $this->viewIsOpen = false;
        $this->reset();
        $this->render();
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|Application
    {
        return view('livewire.pages.internal.partner.view');
    }
}
