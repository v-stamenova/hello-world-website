<div>
    <x-mary-modal box-class="gap-0 w-screen max-w-screen-lg" wire:model="createIsOpen"
                  title="Add a new partner"
                  subtitle="Collaborating with a company or another association? Add them here."
                  >
        <x-mary-form class="w-full grid grid-cols-2 gap-6 items-start auto-rows-min relative" wire:submit.prevent="save">
            <div class="grid gap-3 box-border border-r-2 border-secondary pr-6 h-full">
                <p class="text-lg font-semibold text-gray-700 ">
                    Basic information
                </p>
                <div>
                    <label class="pt-0 label label-text font-semibold inline-flex after:content-['*'] after:text-red-500 after:ml-1">Name</label>
                    <x-mary-input wire:model="name" />
                </div>
                <div>
                    <label class="label label-text font-semibold inline-flex after:content-['*'] after:text-red-500 after:ml-1">Description</label>
                    <x-mary-textarea wire:model="description"
                        hint="Max 1000 chars"
                        rows="5"
                        inline />
                </div>
                <div>
                    <label class="pt-0 label label-text font-semibold inline-flex">Website</label>
                    <x-mary-input wire:model="website" prefix="https://"/>
                </div>
                <div>
                    <label class="pt-0 label label-text font-semibold inline-flex">Type</label>
                    <x-mary-input wire:model="type" hint="E.g. sponsor, association"/>
                </div>
            </div>
            <div class="grid gap-3 box-border pl-0">
                <p class="text-lg font-semibold text-gray-700 ">
                    Contact information
                </p>
                <div>
                    <label class="pt-0 label label-text font-semibold inline-flex">Person of contact</label>
                    <x-mary-input wire:model="contact_person"/>
                </div>
                <div>
                    <label class="pt-0 label label-text font-semibold inline-flex">Email</label>
                    <x-mary-input wire:model="email"/>
                </div>
                <div>
                    <label class="pt-0 label label-text font-semibold inline-flex">Phone number</label>
                    <x-mary-input wire:model="phone_number" hint="Use international format (e.g. +31)"/>
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.myModal2 = false" />
                <x-mary-button label="Confirm" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    <x-mary-button label="Add partner" @click="$wire.createIsOpen = true" />
</div>
