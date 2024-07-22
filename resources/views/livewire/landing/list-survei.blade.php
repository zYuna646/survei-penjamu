<main class="min-h-screen bg-[#f9fafc]">
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24 pb-12" x-data="{ filterModal: false }">
        <div
            class="mt-4 mb-4 p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg">List {{ $master }}</h1>
                <p class="text-slate-500 text-sm">List data {{ $master }} yang berhasil terinput dalam Database</p>
            </div>
            <div class="flex gap-x-2">
                <form class="inline-flex gap-x-2 w-full" wire:submit.prevent="applySearch">
                    <input type="text" wire:model.debounce.300ms="search" placeholder="Masukan Nama {{ $master }}"
                        class="min-w-xl w-full p-2 text-xs rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    <x-button class="" color="info" size="sm" type="submit">
                        <span>
                            <i class="fas fa-search"></i>
                        </span>
                    </x-button>
                </form>
                <div class="inline-flex gap-x-2">
                    <x-button class="inline-flex gap-x-2 items-center" size="sm" color="default"
                        @click="filterModal = !filterModal">
                        <span>
                            <i class="fas fa-filter"></i>
                        </span>
                        Filter
                    </x-button>
                    {{-- Modal Filter --}}
                    <div x-show="filterModal" x-transition
                        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                        <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="filterModal = false">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        Filter {{ $master }}
                                    </h3>
                                    <button type="button" @click="filterModal = false"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                        data-modal-hide="default-modal">
                                        <span>
                                            <i class="fas fa-times"></i>
                                        </span>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <form wire:submit.prevent="applyFilter" class="grid grid-cols-12 p-2">
                                        <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                            <label for="jenis" class="text-sm">Jenis {{ $master }}:</label>
                                            <select wire:model="filterJenis" name="jenis"
                                                class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                                <option value="">Pilih Jenis</option>
                                                @foreach($jenis as $jenis)
                                                <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- @error('jenis.nama')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror --}}
                                        </div>
                                        <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                            <label for="target" class="text-sm">Target {{ $master }}:</label>
                                            <select wire:model="filterTarget" name="target"
                                                class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                                <option value="">Pilih Target</option>
                                                @foreach($target as $target)
                                                <option value="{{ $target->id }}">{{ $target->name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- @error('jenis.nama')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror --}}
                                        </div>
                                        <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12"
                                            color="info" type="submit">
                                            <span wire:loading.remove>
                                                <i class="fas fa-filter"></i>
                                            </span>
                                            <span wire:loading class="animate-spin">
                                                <i class="fas fa-circle-notch"></i>
                                            </span>
                                            Filter {{ $master }}
                                        </x-button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full grid grid-cols-12 gap-4">
            @foreach ($surveis as $survei)
            <a class="p-8 col-span-12 lg:col-span-4 bg-white flex flex-col gap-y-2 gap-x-4 rounded-lg border border-slate-100 hover:border-color-info-500 transition-colors shadow-sm cursor-pointer"
                href="{{ route('run_survei', $survei['code']) }}">
                <div class="max-w-lg flex flex-col gap-y-2">
                    <p class="font-bold text-base">{{ $survei['name'] }}</p>
                    <div class="flex flex-col gap-y-2 font-semibold">
                        <div class="inline-flex gap-x-2 items-center text-xs">
                            <span>
                                <i class="fas fa-bullseye"></i>
                            </span>
                            <p>Target : {{ $survei['target']->name }}</p>
                        </div>
                        <div class="inline-flex gap-x-2 items-center text-xs">
                            <span>
                                <i class="fas fa-server"></i>
                            </span>
                            <p>Jenis : {{ $survei['jenis']->name }}</p>
                        </div>
                        <div class="inline-flex gap-x-2 items-center text-xs text-color-success-500">
                            <span>
                                <i class="fas fa-check"></i>
                            </span>
                            <p>Aspek Total : {{ count($survei->aspek) }}</p>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $surveis->links() }}
        </div>
    </section>
</main>