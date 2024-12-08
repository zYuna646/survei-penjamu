<main class="bg-[#f9fafc] min-h-screen">
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24">
        <div
            class="p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg">Edit {{ $master }}</h1>
                <p class="text-slate-500 text-sm">Edit data {{ $master }} yang berhasil terinput dalam Database</p>
            </div>
            <div>
                <x-button class="" color="danger" size="sm" wire:click="redirectToAdd">
                    Kembali
                </x-button>
            </div>
        </div>
    </section>
    <section class="max-w-screen-xl w-full mx-auto px-4 mt-4 pb-12">
        <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm">
            <form wire:submit.prevent="updateUserProdi" class="grid grid-cols-12">
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="nama" class="text-sm">Nama {{ $master }} :</label>
                    <input type="text" id="nama" name="name" wire:model="userProdi.name"
                        placeholder="Masukan Nama {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('userProdi.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="fakultas" class="text-sm">Fakultas :</label>
                    <select type="fakultas" id="fakultas" name="fakultas" wire:model="userProdi.fakultas_id"
                        wire:change="getJurusanByFakultas"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        <option value="">Pilih Fakultas</option>
                        @foreach($dataFakultas as $fakultas)
                        <option value="{{ $fakultas->id }}">{{ $fakultas->name }}</option>
                        @endforeach
                    </select>
                    @error('userProdi.fakultas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                {{-- <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="jurusan" class="text-sm">Jurusan :</label>
                    <select type="jurusan" id="jurusan" name="jurusan" wire:model="userProdi.jurusan_id"
                        wire:change="getProdiByJurusan"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        <option value="">Pilih Jurusan</option>
                        @foreach($dataJurusan as $jurusan)
                        <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                        @endforeach
                    </select>
                    @error('userProdi.jurusan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div> --}}
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="prodi" class="text-sm">Prodi :</label>
                    <select type="prodi" id="prodi" name="prodi" wire:model="userProdi.prodi_id"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        <option value="">Pilih Prodi</option>
                        @foreach($dataProdi as $prodi)
                        <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                        @endforeach
                    </select>
                    @error('userProdi.prodi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="email" class="text-sm">Email :</label>
                    <input type="email" id="email" name="email" wire:model="userProdi.email"
                        placeholder="Masukan Email {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('userProdi.email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="password" class="text-sm">Password Baru :</label>
                    <input type="password" id="password" name="password" wire:model="userProdi.newpass"
                        placeholder="Masukan Password {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('userProdi.newpass') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="password_confirmation" class="text-sm">Ketik Ulang Password Baru :</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        wire:model="userProdi.password_confirmation" placeholder="Masukan Password {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('userProdi.password_confirmation') <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12" color="info" type="submit">
                    <span wire:loading.remove>
                        <i class="fas fa-edit"></i>
                    </span>
                    <span wire:loading class="animate-spin">
                        <i class="fas fa-circle-notch"></i>
                    </span>
                    Edit {{ $master }}
                </x-button>
            </form>
        </div>
    </section>
</main>