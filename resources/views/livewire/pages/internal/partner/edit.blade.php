<div>
    <x-mary-modal box-class="gap-0 w-screen max-w-screen-lg" wire:model="isEditOpen" persistent
                  title="Edit a new partner"
                  subtitle="Collaborating with a company or another association? Add them here. {{$partnerId}}"
    >
        @if($partnerId)
            <x-mary-form class="w-full grid gap-6 items-start auto-rows-min relative" wire:submit.prevent="save">
                <div class="grid gap-3">
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
                    <div>
                        <x-mary-file hideProgress="true" wire:model="logo" label="Logo" hint="Only images" crop-after-change accept="image/jpeg, image/png, image/gif, image/webp, image/bmp" >
                            <img alt="Placeholder" src="{{$logo_path ? asset('storage/' . $this->logo_path) : config('app.fallback_image_url')}}" class="h-40 rounded-lg" />
                        </x-mary-file>
                        <p>{{$logo_path}}</p>
                    </div>
                    <p class="text-lg font-semibold text-gray-700">
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
                    <p class="text-lg font-semibold text-gray-700">
                        Publishing status
                    </p>
                    <div>
                        <label class="pt-0 label label-text font-semibold inline-flex">Status</label>
                        <x-mary-select :options="$availableStatuses" option-label="display" option-value="value" wire:model="status"/>
                    </div>
                </div>

                <x-slot:actions>
                    <x-mary-button label="Cancel" type="button" wire:click="close" />
                    <x-mary-button label="Confirm" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-mary-form>
        @endif

    </x-mary-modal>
</div>
