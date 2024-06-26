<main class="bg-[#f9fafc] min-h-screen">
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24" x-data="{ addModal : false }">

        <div
            class="mt-4 p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg">{{ $master }}</h1>
                <p class="text-slate-500 text-sm">List data {{ $master }} yang berhasil terinput dalam Database</p>
            </div>
            <div>
                <x-button class="" color="info" size="sm" @click="addModal = !addModal">
                    Tambah {{ $master }}
                </x-button>
            </div>
        </div>
        {{-- add modal --}}
        <div x-show="addModal" x-transition
            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
            <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="addModal = false">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow ">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                        <h3 class="text-lg font-bold text-gray-900 ">
                            Tambah Data {{ $master }}
                        </h3>
                        <button type="button" @click="addModal = false"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                            data-modal-hide="default-modal">
                            <span>
                                <i class="fas fa-times"></i>
                            </span>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <form wire:submit.prevent="addSurvei" class="grid grid-cols-12 p-2">
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="survei" class="text-sm ">Nama {{ $master }} :</label>
                                <input type="text" name="survei" wire:model="survei.nama"
                                    placeholder="Masukan Nama {{ $master }}"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                @error('survei.nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="kode" class="text-sm ">Kode {{ $master }} :</label>
                                <input type="text" name="Kode" wire:model="survei.kode"
                                    placeholder="Masukan Kode {{ $master }}"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                @error('survei.nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="target" class="text-sm ">Target :</label>
                                <select name="target_id" wire:model="master.target_id"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    <option value="">Pilih Target</option>
                                    @foreach($dataTarget as $target)
                                    <option value="{{ $target->id }}">{{ $target->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12" color="info"
                                type="submit">
                                <span wire:loading.remove>
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span wire:loading class="animate-spin">
                                    <i class="fas fa-circle-notch "></i>
                                </span>
                                Tambah {{ $master }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="max-w-screen-xl w-full mx-auto px-4 mt-4 pb-12">
        <div class="p-4 bg-white rounded-lg border-slate-100 shadow-sm ">
            <div class="p-4 overflow-x-auto text-sm">
                <table id="myTable" class="cell-border stripe">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Target</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataSurvei as $survei)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $survei['code'] }}</td>
                            <td>{{ $survei['name'] }}</td>
                            <td>{{ $survei['target'] }}</td>
                            <td>
                                <div class="inline-flex gap-x-1">
                                    <!--Fill button -->
                                    <x-button class="" color="info" size="sm"
                                        onclick="window.location.href='{{ route('create_survei') }}'">
                                        Edit
                                    </x-button>
                                    <!-- Edit button -->
                                    <x-button class="" color="info" size="sm"
                                        onclick="window.location.href='{{ route('detail_survei') }}'">
                                        Detail
                                    </x-button>
                                    <!-- Delete button (if needed) -->
                                    <x-button class="" color="danger" size="sm"
                                        onclick="confirmDelete({{ $survei['id'] }})">
                                        Hapus
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    @push('scripts')
    <script>
        $(document).ready(function() {
        // Inisialisasi DataTables
        var table = $('#myTable').DataTable();
    });
    </script>
    <script>
        function confirmDelete(id) {
            if(confirm(`Hapus fakultas? ${id}`)) {
                @this.call('deleteFakultas', id);
            }
        }
    </script>
    @endpush
</main>