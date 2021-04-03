<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    @if (session()->has('message'))
        <x-alert class="mt-3" color="green">
            <x-slot name="title">Success</x-slot>
            {{session('message')}}
        </x-alert>
    @endif

    <div class="my-3">
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
                            {{ $file->name }}
                        </td>
                        <td class="text-center px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
                            {{ $file->extension }}
                        </td>
                        <td class="text-right px-3 py-3 bg-white text-sm @if (!$loop->last) border-gray-200 border-b @endif">
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
