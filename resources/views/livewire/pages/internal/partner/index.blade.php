<div class="w-full">
    <!-- Page Title -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-primary-content sm:truncate sm:text-3xl sm:tracking-tight">
            Partners
        </h2>
        <!-- Add Partner Button -->
        <livewire:pages.internal.partner.create/>
    </div>

    <div class="mt-5">
        <x-mary-input wire:model.live="search" placeholder="Search for a partner..." class="w-full" />
    </div>

    <div class="mt-5">
        <x-mary-table :headers="$headers" :rows="$partners" :sort-by="$sortBy" >
            @scope('cell_actions', $partner)
                <x-mary-dropdown class="sm">
                    <x-slot:trigger>
                        <x-mary-button class="btn-xs" icon="o-bars-3" />
                    </x-slot:trigger>

                    <x-mary-menu-item title="Change logo" icon="o-photo" />
                    <x-mary-menu-item title="Edit" icon="o-pencil" />
                    <x-mary-menu-item title="Change address" icon="o-building-office-2" />
                    <x-mary-menu-item title="Remove" icon="o-trash" />
                </x-mary-dropdown>
            @endscope

            <x-slot:empty>
                <x-mary-icon class='text-primary-content' name="o-cube" label="It is empty." />
            </x-slot:empty>
        </x-mary-table>
    </div>
</div>
