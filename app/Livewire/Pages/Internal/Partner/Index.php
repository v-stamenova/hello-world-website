<?php

namespace App\Livewire\Pages\Internal\Partner;

use App\Models\Partner;
use App\Services\PartnerService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-primary-content'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-primary-content'],
        ['key' => 'type', 'label' => 'Type', 'class' => 'text-primary-content'],
        ['key' => 'created_at', 'label' => 'Date of creation', 'class' => 'text-primary-content'],
    ];

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public string $search = '';

    public function mount(
      PartnerService $partnerService,
    ){
        $this->partnerService = $partnerService;
    }

    #[On("update-partners-list")]
    public function render()
    {
        $partners = Partner::query()
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->get();

        return view('livewire.pages.internal.partner.index', compact('partners'));
    }
}
