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
                        <form wire:submit.prevent="addUserJurusan" class="grid grid-cols-12 p-2">
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="nama" class="text-sm ">Nama {{ $master }} :</label>
                                <input type="text" name="nama" wire:model="userJurusan.nama"
                                    placeholder="Masukan Nama {{ $master }}"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                @error('userJurusan.nama') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="fakultas" class="text-sm ">fakultas :</label>
                                <select type="fakultas" name="fakultas" wire:model="userJurusan.fakultas_id"
                                    wire:change="getJurusanByFakultas"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    <option value="">Pilih Fakultas</option>
                                    @foreach($dataFakultas as $fakultas)
                                    <option value="{{ $fakultas->id }}">{{ $fakultas->name }}</option>
                                    @endforeach
                                </select>
                                @error('userJurusan.fakultas_id') <span class="text-red-500 text-xs">{{ $message
                                    }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="jurusan" class="text-sm ">Jurusan :</label>
                                <select type="jurusan" name="jurusan" wire:model="userJurusan.jurusan_id"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($dataJurusan as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                                    @endforeach
                                </select>
                                @error('userJurusan.jurusan_id') <span class="text-red-500 text-xs">{{ $message
                                    }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="email" class="text-sm ">Email :</label>
                                <input type="text" name="email" wire:model="userJurusan.email"
                                    placeholder="Masukan Email {{ $master }}"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                @error('userJurusan.email') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="password" class="text-sm ">Password :</label>
                                <input type="password" name="password" wire:model="userJurusan.password"
                                    placeholder="Masukan Password {{ $master }}"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                @error('userJurusan.password') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
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
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataUserJurusan as $userJurusan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $userJurusan['email'] }}</td>
                            <td>{{ $userJurusan['name'] }}</td>
                            <td>{{ $userJurusan->jurusan->name }}</td>
                            <td>
                                <div class="inline-flex gap-x-2">
                                    <!-- Edit button -->
                                    <x-button class="" color="info" size="sm"
                                        onclick="window.location.href='{{ route('edit_user_jurusan' , $userJurusan['id']) }}'">
                                        Edit
                                    </x-button>
                                    <!-- Delete button (if needed) -->
                                    <x-button class="" color="danger" size="sm"
                                        onclick="confirmDelete({{ $userJurusan['id'] }})">
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
            if(confirm(`Hapus User? ${id}`)) {
                @this.call('deleteUser', id);
            }
        }
    </script>
    @endpush
</main>