<main class="bg-[#f9fafc] min-h-screen">
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24">
        <div
            class="p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg">Cetak Laporan {{ $master }}</h1>
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
            <form wire:submit.prevent="downloadDocument" class="grid grid-cols-12">
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="tahun" class="text-sm">Tahun Akademik :</label>
                    <input type="number" min="2000" max="3000" id="tahun" name="tahun" wire:model="createDocument.tahun_akademik"
                        placeholder="Masukan Tahun Akademik {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.tahun_akademik')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="tanggal" class="text-sm">Tanggal Kegiatan :</label>
                    <input type="date" id="tanggal" name="tanggal" wire:model="createDocument.tanggal"
                        placeholder="Masukan Tanggal Kegiatan {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.tanggal')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="fakultas" class="text-sm">Fakultas :</label>
                    <select id="fakultas" name="fakultas" wire:model="createDocument.fakultas_id"
                        wire:change="getProdiByFakultas"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        <option value="">Pilih Fakultas</option>
                        @foreach ($dataFakultas as $fakultas)
                            <option value="{{ $fakultas->id }}">{{ $fakultas->name }}</option>
                        @endforeach
                    </select>
                    @error('createDocument.fakultas_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="prodi" class="text-sm">Prodi :</label>
                    <select id="prodi" name="prodi" wire:model="createDocument.prodi_id"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        <option value="">Pilih Prodi</option>
                        @foreach ($dataProdi as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                        @endforeach
                    </select>
                    @error('createDocument.prodi_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
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