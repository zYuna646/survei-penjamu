<main class="bg-[#f9fafc] min-h-screen"
    x-data="{  ,showToast: {{ session()->has('toastMessage') ? 'true' : 'false' }}, toastMessage: '{{ session('toastMessage') }}', toastType: '{{ session('toastType') }}' }"
    x-init="
    if (showToast) {
        setTimeout(() => showToast = false, 5000);
    }
">
    <!-- Toast -->
    <div x-show="showToast" x-transition
        :class="toastType === 'success' ? 'text-color-success-500' : 'text-color-danger-500'"
        class="fixed top-24 right-5 z-50 flex items-center w-full max-w-xs p-4 rounded-lg shadow bg-white" role="alert">
        <div :class="toastType === 'success' ? 'text-color-success-500 bg-color-success-100' :
            'text-color-danger-500 bg-color-danger-100'"
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg">
            <span>
                <i :class="toastType === 'success' ? 'fas fa-check' : 'fas fa-exclamation'"></i>
            </span>
        </div>
        <div class="ml-3 text-sm font-normal" x-text="toastMessage"></div>
        <button type="button" @click="showToast = false"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
            aria-label="Close">
            <span><i class="fas fa-times"></i></span>
        </button>
    </div>
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24">

        <div
            class="mt-4 p-6 bg-white flex flex-col lg:flex-row lg:items-center gap-y-2 justify-between rounded-lg border border-slate-100 shadow-sm">
            <div>
                <h1 class="font-bold text-lg">{{ $master }}</h1>
                <p class="text-slate-500 text-sm">Indikator : {{ $indikator->name }}</p>
            </div>
            <div>
                <x-button class="" color="danger" size="sm"
                    onclick="window.location.href='{{ route('master_survei') }}'">
                    Kembali
                </x-button>
            </div>
        </div>

    </section>
    <section class="max-w-screen-xl w-full mx-auto px-4 mt-4 pb-12" x-data="{ userRole: '{{ $user->role->slug }}' }">
        @if ($user->role->slug === 'universitas')
        <div x-if="userRole === 'universitas'" class="flex flex-col gap-y-2 mb-4"
            x-data="{ addUniversitasTemuan : false, addUniversitasSolusi : false, expand : false, editUniversitasTemuan : false, editUniversitasSolusi : false }">
            <div class="w-full flex justify-between items-center p-5 bg-white rounded-lg border-slate-100 shadow-sm ">
                <h4 class=" font-semibold">Temuan Univertias ({{ count($dataTemuanUniv) }})</h4>
                <div class="inline-flex gap-x-2">
                    <x-button size="sm" color="default" @click="addUniversitasTemuan = !addUniversitasTemuan">
                        Buat Temuan
                    </x-button>
                    <x-button size="sm" color="default" @click="expand = !expand">
                        <span>
                            <i :class="expand ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </span>
                    </x-button>
                </div>
            </div>
            @foreach ($dataTemuanUniv as $item)
            <div x-show="expand" x-transition style="display: none"
                class="w-full flex flex-col gap-y-2 p-6 bg-white rounded-lg border-slate-100 shadow-sm">
                <div class="flex flex-col gap-y-2">
                    <div class="w-full inline-flex justify-between items-center">
                        <div class="inline-flex text-slate-500 gap-x-2 items-center">
                            <div class="w-5">
                                <img src="{{ Auth::user()->avatar_url ?? '/avatar/placeholder.jpg' }}" alt=""
                                    class="w-full rounded-full hover:cursor-pointer" />
                            </div>
                            <span class="text-xs font-semibold">Admin, {{ $item->created_at }}</span>
                        </div>
                        <button class="inline-flex gap-x-1 text-color-danger-500 text-xs font-semibold"
                            onclick="confirmDelete({{ $item->id }})">
                            <span>
                                <i class="fas fa-trash"></i>
                            </span>
                        </button>
                    </div>
                    <p class="font-semibold px-1 text-sm">{{ $item->temuan }}.

                            </p>
                        </div>
                        <hr class="mt-4 mb-4">
                        <div class="flex flex-col items-center justify-center">
                            @if (is_null($item->solusi))
                                <span class="text-sm italic py-4 font-semibold">- Solusi belum tersedia -</span>
                                <x-button color="default" size="sm"
                                    @click="addUniversitasSolusi = !addUniversitasSolusi">
                                    Buat Solusi
                                </x-button>
                            @else
                                <div class="w-full p-4 flex flex-col gap-y-2 rounded-md border border-color-info-500">
                                    <span class="text-sm font-semibold">Solusi: </span>
                                    <p class="text-sm">{{ $item->solusi }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- add universitas solusi --}}
                    <div x-show="addUniversitasSolusi" style="display: none"
                        x-on:keydown.escape.window="addUniversitasSolusi = false"
                        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                        <div class="relative p-4 w-full max-w-2xl max-h-full"
                            @click.outside="addUniversitasSolusi = false">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow ">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                    <h3 class="text-lg font-bold text-gray-900 ">
                                        Solusi
                                    </h3>
                                    <button type="button" @click="addUniversitasSolusi = false"
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
                                    <form wire:submit.prevent="addSolusi({{ $item->id }})"
                                        class="grid grid-cols-12 p-2">
                                        <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                            <label for="solusi" class="text-sm ">Solusi :</label>
                                            <textarea id="solusi" name="solusi" wire:model="solusi" placeholder="Masukan Solusi"
                                                class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                            @error('solusi')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12"
                                            color="info" type="submit">
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
                @endforeach

            {{-- universitas temuan add --}}
            <div x-show="addUniversitasTemuan" style="display: none"
                x-on:keydown.escape.window="addUniversitasTemuan = false"
                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="addUniversitasTemuan = false">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow ">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 class="text-lg font-bold text-gray-900 ">
                                Tambah {{ $master }} Universitas
                            </h3>
                            <button type="button" @click="addUniversitasTemuan = false"
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
                            <form wire:submit.prevent="addTemuanUniversitas" class="grid grid-cols-12 p-2">
                                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                    <label for="temuan" class="text-sm ">{{ $master }} :</label>
                                    <textarea id="temuan" name="temuan" wire:model="temuan"
                                        placeholder="Masukan {{ $master }}"
                                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                    @error('temuan') <span class="text-red-500 text-xs">{{ $message
                                        }}</span>
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
        </div>
        @endif

        @if ($user->role->slug === 'fakultas')
        <div x-if="userRole === 'fakultas'" class="flex flex-col gap-y-2 mb-4"
            x-data="{ addFakultasTemuan : false, addFakultasSolusi : false, expand : false, editUniversitasTemuan : false, editUniversitasSolusi : false }">
            <div class="w-full flex justify-between items-center p-5 bg-white rounded-lg border-slate-100 shadow-sm ">
                <h4 class=" font-semibold">Temuan Fakultas ({{ count($dataTemuanFakultas) }})</h4>
                <div class="inline-flex gap-x-2">
                    <x-button size="sm" color="default" @click="addFakultasTemuan = !addFakultasTemuan">
                        Buat Temuan
                    </x-button>
                    <x-button size="sm" color="default" @click="expand = !expand">
                        <span>
                            <i :class="expand ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </span>
                    </x-button>
                </div>
            </div>
            @foreach ($dataTemuanFakultas as $item)
            <div x-show="expand" x-transition style="display: none"
                class="w-full flex flex-col gap-y-2 p-6 bg-white rounded-lg border-slate-100 shadow-sm">
                <div class="flex flex-col gap-y-2">
                    <div class="w-full inline-flex justify-between items-center">
                        <div class="inline-flex text-slate-500 gap-x-2 items-center">
                            <div class="w-5">
                                <img src="{{ Auth::user()->avatar_url ?? '/avatar/placeholder.jpg' }}" alt=""
                                    class="w-full rounded-full hover:cursor-pointer" />
                            </div>
                            <span class="text-xs font-semibold">{{ $item->fakultas->name }} , {{ $item->created_at
                                }}</span>
                        </div>
                        <button class="inline-flex gap-x-1 text-color-danger-500 text-xs font-semibold"
                            onclick="confirmDelete({{ $item->id }})">
                            <span>
                                <i class="fas fa-trash"></i>
                            </span>
                        </button>
                    </div>

                            <p class="font-semibold px-1 text-sm">{{ $item->temuan }}. </p>
                        </div>
                        <hr class="mt-4 mb-4">
                        <div class="flex flex-col items-center justify-center">
                            @if (is_null($item->solusi))
                                <span class="text-sm italic py-4 font-semibold">- Solusi belum tersedia -</span>
                                <x-button color="default" size="sm"
                                    @click="addFakultasSolusi = !addFakultasSolusi">
                                    Buat Solusi
                                </x-button>
                            @else
                                <div class="w-full p-4 flex flex-col gap-y-2 rounded-md border border-color-info-500">
                                    <span class="text-sm font-semibold">Solusi: </span>
                                    <p class="text-sm">{{ $item->solusi }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- add fakultas solusi --}}
                    <div x-show="addFakultasSolusi" style="display: none"
                        x-on:keydown.escape.window="addFakultasSolusi = false"
                        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                        <div class="relative p-4 w-full max-w-2xl max-h-full"
                            @click.outside="addFakultasSolusi = false">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow ">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                    <h3 class="text-lg font-bold text-gray-900 ">
                                        Solusi
                                    </h3>
                                    <button type="button" @click="addFakultasSolusi = false"
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
                                    <form wire:submit.prevent="addSolusi({{ $item->id }})"
                                        class="grid grid-cols-12 p-2">
                                        <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                            <label for="solusi" class="text-sm ">Solusi :</label>
                                            <textarea id="solusi" name="solusi" wire:model="solusi" placeholder="Masukan Solusi"
                                                class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                            @error('solusi')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12"
                                            color="info" type="submit">
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
                @endforeach

            {{-- fakultas temuan add --}}
            <div x-show="addFakultasTemuan" style="display: none" x-on:keydown.escape.window="addFakultasTemuan = false"
                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="addFakultasTemuan = false">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow ">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 class="text-lg font-bold text-gray-900 ">
                                Tambah {{ $master }} Universitas
                            </h3>
                            <button type="button" @click="addFakultasTemuan = false"
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
                            <form wire:submit.prevent="addTemuanFakultas" class="grid grid-cols-12 p-2">
                                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                    <label for="temuan" class="text-sm ">{{ $master }} :</label>
                                    <textarea id="temuan" name="temuan" wire:model="temuan"
                                        placeholder="Masukan {{ $master }}"
                                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                    @error('temuan') <span class="text-red-500 text-xs">{{ $message
                                        }}</span>
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
        </div>
        @endif




        @if ($user->role->slug === 'prodi')
        <div x-if="userRole === 'prodi'" class="flex flex-col gap-y-2 mb-4"
            x-data="{ addProdiTemuan : false, addProdiSolusi : false, expand : false, editUniversitasTemuan : false, editUniversitasSolusi : false }">
            <div class="w-full flex justify-between items-center p-5 bg-white rounded-lg border-slate-100 shadow-sm ">
                <h4 class=" font-semibold">Temuan Prodi ({{ count($dataTemuanProdi) }})</h4>
                <div class="inline-flex gap-x-2">
                    @if (Auth::user()->role->name == 'prodi')
                        <x-button size="sm" color="default" @click="addProdiTemuan = !addProdiTemuan">
                            Buat Temuan
                        </x-button>
                    @endif

                    <x-button size="sm" color="default" @click="expand = !expand">
                        <span>
                            <i :class="expand ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </span>
                    </x-button>
                </div>
            </div>
            @foreach ($dataTemuanProdi as $item)
                <div x-show="expand" x-transition
                    class="w-full flex flex-col gap-y-2 p-6 bg-white rounded-lg border-slate-100 shadow-sm">
                    <div class="flex flex-col gap-y-2">
                        <div class="w-full inline-flex justify-between items-center">

                            <div class="inline-flex text-slate-500 gap-x-2 items-center">
                                <div class="w-5">
                                    <img src="{{ Auth::user()->avatar_url ?? '/avatar/placeholder.jpg' }}"
                                        alt="" class="w-full rounded-full hover:cursor-pointer" />
                                </div>
                                <span class="text-xs font-semibold">{{ $item->prodi->name }} ,
                                    {{ $item->created_at }}</span>

                            </div>
                            <button class="inline-flex gap-x-1 text-color-danger-500 text-xs font-semibold"
                                onclick="confirmDelete({{ $item->id }})">
                                <span>
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </div>
                        <p class="font-semibold px-1 text-sm">{{ $item->temuan }}. </p>
                    </div>
                    <hr class="mt-4 mb-4">
                    <div class="flex flex-col items-center justify-center">

                        @if (is_null($item->solusi))
                            <span class="text-sm italic py-4 font-semibold">- Solusi belum tersedia -</span>
                            <x-button color="default" size="sm" @click="addProdiSolusi = !addProdiSolusi">
                                Buat Solusi
                            </x-button>
                        @else
                            <div class="w-full p-4 flex flex-col gap-y-2 rounded-md border border-color-info-500">
                                <span class="text-sm font-semibold">Solusi: </span>
                                <p class="text-sm">{{ $item->solusi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- add prodi solusi --}}
                <div x-show="addProdiSolusi" style="display: none"
                    x-on:keydown.escape.window="addProdiSolusi = false"
                    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                    <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="addProdiSolusi = false">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow ">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                <h3 class="text-lg font-bold text-gray-900 ">
                                    Solusi
                                </h3>
                                <button type="button" @click="addProdiSolusi = false"
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
                                <form wire:submit.prevent="addSolusi({{ $item->id }})"
                                    class="grid grid-cols-12 p-2">
                                    <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                        <label for="solusi" class="text-sm ">Solusi :</label>
                                        <textarea id="solusi" name="solusi" wire:model="solusi" placeholder="Masukan Solusi"
                                            class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                        @error('solusi')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12"
                                        color="info" type="submit">
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
            @endforeach

            {{-- prodi temuan add --}}
            <div x-show="addProdiTemuan" style="display: none" x-on:keydown.escape.window="addProdiTemuan = false"
                class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="addProdiTemuan = false">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow ">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                            <h3 class="text-lg font-bold text-gray-900 ">
                                Tambah {{ $master }} Universitas
                            </h3>
                            <button type="button" @click="addProdiTemuan = false"
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
                            <form wire:submit.prevent="addTemuanProdi" class="grid grid-cols-12 p-2">
                                <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                    <label for="temuan" class="text-sm ">{{ $master }} :</label>
                                    <textarea id="temuan" name="temuan" wire:model="temuan" placeholder="Masukan {{ $master }}"
                                        class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                    @error('temuan')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
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
        </div>
        @endif


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
                if (confirm(`Hapus temuan?`)) {
                    @this.call('deleteTemuan', id);
                }
            }
        </script>
        <script>
            function confirmStatus(id) {
                if (confirm(`Ubah Status Survei?`)) {
                    @this.call('changeSurveiStatus', id);
                }
            }
        </script>
    @endpush
</main>
