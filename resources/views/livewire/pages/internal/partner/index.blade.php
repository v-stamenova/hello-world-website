<div class="w-full">
    <!-- Page Title -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-primary-content sm:truncate sm:text-3xl sm:tracking-tight">
            Partners
        </h2>
        <x-mary-button label="Add partner" wire:click="openCreate()"/>
    </div>

    <div class="mt-5">
        <x-mary-input wire:model.live="search" placeholder="Search for a partner..." class="w-full" />
    </div>

    <div class="mt-5">
        <x-mary-table :headers="$headers" :rows="$partners" :sort-by="$sortBy">
            @scope('cell_actions', $partner)
                <x-mary-button class="btn-xs" icon="o-pencil" wire:click="openEdit({{$partner->id}})" tooltip="Edit"/>
{{--
                    <x-mary-button class="btn-xs" icon="o-pencil" wire:click="editPartner({{ $partner->id }})" tooltip="Edit" />
                    <x-mary-button class="btn-xs" icon="o-building-office-2" wire:click="changeAddress({{ $partner->id }})" tooltip="Change Address" />
                    <x-mary-button class="btn-xs" icon="o-trash" wire:click="removePartner({{ $partner->id }})" tooltip="Remove" />
--}}
            @endscope

            <x-slot:empty>
                <x-mary-icon class='text-primary-content' name="o-cube" label="It is empty." />
            </x-slot:empty>
        </x-mary-table>

        <livewire:pages.internal.partner.edit/>
        <livewire:pages.internal.partner.create/>
        {{--
                <livewire:pages.internal.partner.changeLogo />
        --}}
    </div>
</div>
