<div>
    <x-mary-modal box-class="gap-0 w-screen max-w-screen-lg" wire:model="viewIsOpen"
                  title="Partner Details"
                  subtitle="Detailed information about the selected partner."
                  persistent>
        <div class="w-full grid gap-6 items-start auto-rows-min relative">
            @if($partner)
                <div class="grid gap-3">
                    <div class="grid gap-3 border border-primary p-3 rounded-lg">
                        <p class="text-lg font-semibold text-gray-700">
                            Basic Information
                        </p>
                        <div>
                            <label class="font-semibold">Partner Name</label>
                            <p class="text-gray-800 text-md">{{ $partner->name }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Description</label>
                            <p class="text-gray-800">{{ $partner->description }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Website URL</label>
                            <p class="text-gray-800">{{ $partner->website }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Partner Type</label>
                            <p class="text-gray-800">{{ $partner->type }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Logo</label>
                            @if($partner->logo_path)
                                <img alt="Partner Logo" src="{{ asset('storage/' . $partner->logo_path) }}" class="h-40 rounded-lg" />
                            @else
                                <p class="text-error">Not added</p>
                            @endif
                        </div>
                    </div>
                    <div class="grid gap-3 border border-primary p-3 rounded-lg">
                        <p class="text-lg font-semibold text-gray-700">
                            Contact Information
                        </p>
                        <div>
                            <label class="font-semibold">Contact Person</label>
                            <p class="{{ $partner->contact_person ? 'text-gray-800' : 'text-error' }}">{{ $partner->contact_person ?? 'Not added' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Email Address</label>
                            <p class="text-gray-800">{{ $partner->email }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Phone Number</label>
                            <p class="{{ $partner->phone_number ? 'text-gray-800' : 'text-error' }}">{{ $partner->phone_number ?? 'Not added' }}</p>
                        </div>
                    </div>
                    <div class="grid gap-3 border border-primary p-3 rounded-lg">
                        <p class="text-lg font-semibold text-gray-700">
                            Publishing Status
                        </p>
                        <div>
                            <label class="font-semibold">Current Status</label>
                            <p class="text-gray-800">{{ ucfirst($partner->status) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <x-slot:actions>
                <x-mary-button label="Close" type="button" wire:click="close" />
            </x-slot:actions>
        </div>
    </x-mary-modal>
</div>
