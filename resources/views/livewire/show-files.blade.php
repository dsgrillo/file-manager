<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    @if (session()->has('message'))
        <x-alert class="mt-3">
            <x-slot name="title">Success</x-slot>
            {{session('message')}}
        </x-alert>
    @endif

    <div class="my-3 text-right">
        <x-button-link href="{{route('file.upload')}}" >Upload new file</x-button-link>
    </div>

    @if (count($files)>0)
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                <tr>
                    <th
                        class="sm:w-1/2 md:w-2/3 px-3 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                        {{ __('File Name') }}
                    </th>
                    <th
                        class="px-3 py-3 border-b-2 border-r-2 border-l-2 border-black bg-black text-center text-xs font-semibold text-white uppercase tracking-wider">
                        {{__('Type')}}
                    </th>
                    <th class="px-3 py-3 border-b-2 border-black bg-black text-center text-xs font-semibold text-white uppercase tracking-wider">
                        {{__('Size')}}
                    </th>
                    <th
                        class="px-3 py-3 border-b-2 border-black bg-black tracking-wider">
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr>
                        <td class="px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                            @if ($isUpdating === $file->id)
                                <x-input type="text" class="w-full" wire:model="name" ></x-input>

                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            @else
                            <a class="inline-flex items-center underline text-blue-500" href="#!" wire:click="download({{ $file->id }})">
                                <svg class="w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                                <span>{{ $file->name }}</span>
                            </a>
                            @endif
                        </td>
                        <td class="text-center px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                            {{ $file->extension }}
                        </td>
                        <td class="text-right px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                            {{ $file->sizeUnit }}
                        </td>
                        <td class="px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif text-right">
                            <div class="inline-block whitespace-no-wrap">
                                @if ($isUpdating === $file->id)
                                    <x-button wire:click="updateName({{$file->id}})" class="bg-green-500 hover:bg-green-700">Save</x-button>
                                    <x-button wire:click="cancelUpdate()">Cancel</x-button>
                                @else
                                    <x-button wire:click="setIsUpdating({{$file->id}}, '{{addslashes($file->name)}}')" class="bg-blue-500 hover:bg-blue-700" >
                                        Update
                                    </x-button>

                                    <x-button
                                        class="bg-red-500 hover:bg-red-700"
                                        wire:click="$emit('triggerDelete',{id: {{ $file->id }}, name: '{{ addslashes($file->name) }}'})"
                                    >
                                        Delete
                                    </x-button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $files->links() }}
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
        @this.on('triggerDelete', ({id, name}) => {
            Swal.fire({
                title: 'Are You Sure?',
                text: `The file "${name}" will be permanently deleted!`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                if (result.value) {
                @this.call('delete', id);
                }
            });
        });
        })
    </script>
@endpush
