<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="min-h-screen flex flex-col pt-6 bg-gray-100">
        <div class="w-full sm:max-w-xl mx-auto mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form wire:submit.prevent="save">

            @csrf

            <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" wire:model="name" :placeholder="__('Enter the file name')" type="text" class="block mt-1 w-full"  required />

                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <x-label :value="__('Attachment')" />

                    <x-file-attachment
                        :file="$file"
                        wire:model="file"
                        required
                    />

                    @error('file') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror

                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
