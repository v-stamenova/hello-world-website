<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Services\PartnerService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.internal')]
class Index extends Component
{
    use WithPagination;

    #[Locked]
    protected PartnerService $partnerService;

    /**
     * @var array<int, array{key: string, label: string, class: string}>
     */
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-primary-content text-sm'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-primary-content text-sm'],
        ['key' => 'type', 'label' => 'Type', 'class' => 'text-primary-content text-sm'],
        ['key' => 'created_at', 'label' => 'Date of creation', 'class' => 'text-primary-content text-sm'],
        ['key' => 'actions', 'label' => 'Actions', 'class' => 'text-primary-content text-sm'],
    ];

    /**
     * @var array{column: string, direction: string}
     */
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public string $search = '';

    public function boot(PartnerService $partnerService): void
    {
        $this->partnerService = $partnerService;
    }

    #[On('update-partners-list')]
    public function render(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $partners = $this->partnerService->getPartnersSortedAndFiltered($this->sortBy, $this->search);

        return view('livewire.pages.internal.partner.index', compact('partners'));
    }
}
