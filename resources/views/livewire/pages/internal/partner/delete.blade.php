<div>
    <x-mary-modal box-class="gap-0 w-screen max-w-screen-lg" wire:model="deleteIsOpen" persistent
                  title="Delete {{optional($partner)->name}}?"
                  subtitle="This action cannot be reverted."
    >
        @if($partnerId)
            <x-mary-form wire:submit.prevent="confirm">
                <x-slot:actions>
                    <x-mary-button label="Cancel" type="button" wire:click="close" />
                    <x-mary-button label="Confirm" class="btn-error" type="submit" spinner="save" />
                </x-slot:actions>
            </x-mary-form>
        @endif

    </x-mary-modal>
</div>
