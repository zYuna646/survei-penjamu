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
                    <input type="number" min="2000" max="3000" id="tahun" name="tahun"
                        wire:model="createDocument.tahun_akademik"
                        placeholder="Masukan Tahun Akademik {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.tahun_akademik')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="tanggal" class="text-sm">Tanggal Kegiatan Mulai :</label>
                    <input type="date" id="tanggal" name="tanggal" wire:model="createDocument.tanggal-mulai"
                        placeholder="Masukan Tanggal Kegiatan {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.tanggal')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="tanggal" class="text-sm">Tanggal Kegiatan Selesai :</label>
                    <input type="date" id="tanggal" name="tanggal" wire:model="createDocument.tanggal-selesai"
                        placeholder="Masukan Tanggal Kegiatan {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.tanggal')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="flex flex-col gap-y-2 col-span-12 mb-4">
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
                </div> --}}
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="nama_mengetahui" class="text-sm">Nama Mengetahui :</label>
                    <input type="text" id="nama_mengetahui" name="nama_mengetahui"
                        wire:model="createDocument.nama_mengetahui"
                        placeholder="Masukan Nama Mengetahui {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.nama_mengetahui')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="jabatan_mengetahui" class="text-sm">Jabatan Mengetahui :</label>
                    <input type="text" id="jabatan_mengetahui" name="jabatan_mengetahui"
                        wire:model="createDocument.jabatan_mengetahui"
                        placeholder="Masukan Nama Mengetahui {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.jabatan_mengetahui')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="nip_mengetahui" class="text-sm">NIP Mengetahui :</label>
                    <input type="number" id="nip_mengetahui" name="nip_mengetahui"
                        wire:model="createDocument.nip_mengetahui"
                        placeholder="Masukan NIP Mengetahui {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.nip_mengetahui')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="nama_penanggung_jawab" class="text-sm">Nama Penanggung Jawab :</label>
                    <input type="text" id="nama_penanggung_jawab" name="nama_penanggung_jawab"
                        wire:model="createDocument.nama_penanggung_jawab"
                        placeholder="Masukan Nama Penanggung Jawab {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.nama_penanggung_jawab')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="jabatan_penanggung_jawab" class="text-sm">Jabatan Penanggung Jawab :</label>
                    <input type="text" id="jabatan_penanggung_jawab" name="jabatan_penanggung_jawab"
                        wire:model="createDocument.jabatan_penanggung_jawab"
                        placeholder="Masukan Nama Penanggung Jawab {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.jabatan_penanggung_jawab')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                    <label for="nip_penanggung_jawab" class="text-sm">NIP Penanggung Jawab :</label>
                    <input type="number" id="nip_penanggung_jawab" name="nip_penanggung_jawab"
                        wire:model="createDocument.nip_penanggung_jawab"
                        placeholder="Masukan NIP Penanggung Jawab {{ $master }}"
                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('createDocument.nip_penanggung_jawab')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12" color="info" type="submit">
                    <span wire:loading.remove>
                        <i class="fas fa-download"></i>
                    </span>
                    <span wire:loading class="animate-spin">
                        <i class="fas fa-circle-notch"></i>
                    </span>
                    Cetak {{ $master }}
                </x-button>
            </form>
        </div>
    </section>
</main>
