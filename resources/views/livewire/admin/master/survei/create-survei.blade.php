    <main class="bg-[#f9fafc] min-h-screen">
        <section class="max-w-screen-xl w-full mx-auto px-4 pt-24">
            <div
                class="p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
                <div>
                    <h1 class="font-bold text-lg">Lengkapi {{ $master }}</h1>
                    <p class="text-slate-500 text-sm">Lengkapi data {{ $master }} yang berhasil terinput dalam Database</p>
                </div>
                <div>
                    <x-button color="danger" size="sm" wire:click="redirectToAdd">
                        Kembali
                    </x-button>
                </div>
            </div>
        </section>
        <section class="max-w-screen-xl w-full mx-auto px-4 mt-4 pb-12">
            <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm">
                <form wire:submit.prevent="dumpRequestData" class="grid grid-cols-12 gap-4">

                    {{-- Detail Survei section --}}
                    <div class="col-span-12 text-lg font-bold mb-2">
                        <p>Detail Survei</p>
                    </div>
                    <div class="flex flex-col gap-y-2 col-span-4 mb-4 ">
                        <label for="name" class="text-sm">Nama {{ $master }}</label>
                        <input type="text" name="name" wire:model="survei.name" placeholder="Masukan Nama {{ $master }}"
                            class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        @error('survei.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-y-2 col-span-4 mb-4 ">
                        <label for="jenis" class="text-sm">Jenis {{ $master }}</label>
                        <select type="text" name="jenis" wire:model="survei.jenis_id" placeholder="Masukan Nama {{ $master }}"
                            class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                            <option value="">Pilih Jenis</option>
                            @foreach($dataJenis as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                            @endforeach
                        </select>
                        @error('survei.jenis_id') <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-y-2 col-span-4 mb-4 ">
                        <label for="target" class="text-sm">Target {{ $master }}</label>
                        <select type="text" name="target" wire:model="survei.target_id" placeholder="Masukan Nama {{ $master }}"
                            class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                            <option value="">Pilih Target</option>
                            @foreach($dataTarget as $target)
                            <option value="{{ $target->id }}">{{ $target->name }}</option>
                            @endforeach
                        </select>
                        @error('survei.target_id') <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- End Detail survei section --}}

                    <hr class="col-span-12">
                    <div class="col-span-12 w-full inline-flex justify-between mb-4">
                        <div class="text-lg font-bold">
                            <p>Aspek</p>
                        </div>
                        <div>
                            <x-button class="inline-flex items-center justify-center" size="sm" color="info"
                                wire:click.prevent="addAspek">
                                <i class="fas fa-plus"></i>
                            </x-button>
                        </div>
                    </div>
                    @foreach ($aspeks as $aspekIndex => $aspek)
                    <div class="col-span-12 w-full flex flex-col gap-y-4 mb-4">
                        <div class="w-full bg-white border border-neutral-200 rounded-lg">
                            <div class="inline-flex justify-between w-full p-4 gap-x-4">
                                <div class="w-full">
                                    <input type="text" wire:model="aspeks.{{ $aspekIndex }}.name"
                                        placeholder="Masukan Nama Aspek"
                                        class="w-full max-w-lg p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="inline-flex items-center gap-x-2">
                                    <x-button class="inline-flex gap-x-2 items-center justify-center" size="sm" color="info"
                                        wire:click.prevent="addIndikator({{ $aspekIndex }})">
                                        <i class="fas fa-plus"></i>
                                        Indikator
                                    </x-button>
                                    <x-button class="inline-flex gap-x-2 items-center justify-center" size="sm"
                                        color="danger" wire:click.prevent="removeAspek({{ $aspekIndex }})">
                                        Hapus
                                    </x-button>
                                </div>
                            </div>
                            <hr class="w-full">
                            <div class="flex flex-col p-4">
                                @foreach ($aspek['indikators'] as $indikatorIndex => $indikator)
                                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                    <div class="inline-flex items-center justify-between">
                                        <label for="indikator_{{ $aspekIndex }}_{{ $indikatorIndex }}" class="text-sm">{{
                                            'Indikator ' . ($indikatorIndex + 1) }} :</label>
                                        <button class="text-sm font-semibold underline text-color-danger-500"
                                            wire:click.prevent="removeIndikator({{ $aspekIndex }}, {{ $indikatorIndex }})">
                                            Hapus
                                        </button>
                                    </div>
                                    <input type="text" id="indikator_{{ $aspekIndex }}_{{ $indikatorIndex }}"
                                        wire:model="aspeks.{{ $aspekIndex }}.indikators.{{ $indikatorIndex }}.name"
                                        placeholder="Masukan Isi Indikator"
                                        class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    @error('aspeks.{{ $aspekIndex }}.indikators.{{ $indikatorIndex }}.name') <span
                                        class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12" color="info" type="submit">
                        <span wire:loading.remove>
                            <i class="fas fa-check"></i>
                        </span>
                        <span wire:loading class="animate-spin">
                            <i class="fas fa-circle-notch"></i>
                        </span>
                        Kirim {{ $master }}
                    </x-button>
                </form>
            </div>
        </section>
    </main>