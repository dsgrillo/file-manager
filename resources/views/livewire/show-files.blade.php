<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Files') }}
    </h2>
</x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div id="alert" class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-green-500">
            <span class="inline-block align-middle mr-8">
                {{ session('message') }}
            </span>
            <button
                class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none"
                onclick="document.getElementById('alert').remove();">
                <span>×</span>
            </button>
        </div>
    @endif
    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-10">
        Upload new file
    </button>
    @if (count($files)>0)
        <div class="py-10">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr>
                        <th
                            class="w-3/4 px-3 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                            {{ __('File Name') }}
                        </th>
                        <th
                            class="px-3 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                            {{__('Type')}}
                        </th>
                        <th class="px-3 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                            {{__('Size')}}
                        </th>
                        <th
                            class="px-3 py-3 border-b-2 border-black bg-black text-left text-xs font-semibold text-white uppercase tracking-wider">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($files as $file)
                        <tr>
                            <td class="px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                                {{ $file->name }}
                            </td>
                            <td class="px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                                {{ $file->extension }}
                            </td>
                            <td class="px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                                {{ $file->sizeUnit }}
                            </td>
                            <td class="px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif text-right">
                                <div class="inline-block whitespace-no-wrap">
                                    <button
                                        wire:click="$emit('triggerDelete',{id: {{ $file->id }}, name: '{{ addslashes($file->name) }}'})"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    @if($isOpen)
        <div class="fixed z-100 w-full h-full bg-gray-500 opacity-75 top-0 left-0"></div>
        <div class="fixed z-101 w-full h-full top-0 left-0 overflow-y-auto">
            <div class="table w-full h-full py-6">
                <div class="table-cell text-center align-middle">
                    <div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl">
                            <form wire:submit.prevent="save">
                                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3 mb-6">
                                            <label for="titleInput" class="block text-gray-700 text-sm font-bold mb-2">File
                                                Name:</label>
                                            <input type="text"
                                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                   id="titleInput" placeholder="Enter the file name" wire:model="fileName">
                                            @error('fileName') <span class="text-red-500">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="w-full px-3 mb-6">
                                            <label for="file"
                                                   class="block text-gray-700 text-sm font-bold mb-2">File:</label>
                                            <input type="file"
                                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                   id="file" wire:model="file">
                                            @error('file') <span class="text-red-500">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 sm:px-6 flex-reverse">
                                    <button type="submit"
                                            class="mx-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Save
                                    </button>
                                    <button wire:click="closeModal()" type="button"
                                            class="bg-white hover:bg-gray-200 border border-gray-300 text-gray-500 font-bold py-2 px-4 rounded">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                text: `The file ${name} will be permanently deleted!`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
