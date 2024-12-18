<div class="w-full">
    <!-- Page Title -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-primary-content sm:truncate sm:text-3xl sm:tracking-tight">
            Partners
        </h2>
        <x-mary-button label="Add partner" @click="$dispatch('open-create')"/>
    </div>

    <div class="mt-5">
        <x-mary-input wire:model.live="search" placeholder="Search for a partner..." class="w-full" />
    </div>

    <div class="mt-5">
        <x-mary-table :headers="$headers" :rows="$partners" :sort-by="$sortBy">
            @scope('cell_actions', $partner)
                <x-mary-button class="btn-xs" icon="o-eye" @click="$dispatch('open-view', { partnerId: {{$partner->id}} })" tooltip="Preview"/>
                <x-mary-button class="btn-xs" icon="o-pencil" @click="$dispatch('open-edit', { partnerId: {{$partner->id}} })" tooltip="Edit"/>
                <x-mary-button class="btn-xs" icon="o-trash" @click="$dispatch('open-delete', { partnerId: {{$partner->id}} })" tooltip="Remove" />
            @endscope

            <x-slot:empty>
                <x-mary-icon class='text-primary-content' name="o-cube" label="It is empty." />
            </x-slot:empty>
        </x-mary-table>

        <livewire:pages.internal.partner.edit/>
        <livewire:pages.internal.partner.create/>
        <livewire:pages.internal.partner.delete/>
        <livewire:pages.internal.partner.view/>
        {{--
                <livewire:pages.internal.partner.changeLogo />
        --}}
    </div>
</div>
