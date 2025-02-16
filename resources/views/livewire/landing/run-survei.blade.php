<main class="bg-[#f9fafc] min-h-screen" x-data="{ showToast: {{ session()->has('toastMessage') ? 'true' : 'false' }}, toastMessage: '{{ session('toastMessage') }}', toastType: '{{ session('toastType') }}' }" x-init="if (showToast) {
    setTimeout(() => showToast = false, 5000);
}">
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

    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24 grid grid-cols-12 gap-4 pb-12">
        <div
            class="p-8 col-span-12 lg:col-span-4 h-fit bg-white flex flex-col lg:flex-row  gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
            <div class="max-w-lg flex flex-col gap-y-2">
                <h1 class="font-bold text-base">{{ $dataSurvei['name'] }}</h1>
                {{-- <p class="text-slate-500 text-sm">{{ $dataSurvei['description'] }}</p> --}}
                <div class="flex flex-col gap-y-2 font-semibold">
                    <div class="inline-flex gap-x-2 items-center text-xs">
                        <span>
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <p>Target : {{ $dataSurvei['target']->name }}</p>
                    </div>
                    <div class="inline-flex gap-x-2 items-center text-xs">
                        <span>
                            <i class="fas fa-server"></i>
                        </span>
                        <p>Jenis Survei : {{ $dataSurvei['jenis']->name }}</p>
                    </div>
                    <div class="inline-flex gap-x-2 items-center text-xs text-color-success-500">
                        <span>
                            <i class="fas fa-check"></i>
                        </span>
                        <p>Aspek Total : {{ count($data) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{
            isAktif: @json($dataSurvei->isAktif),
            isDataEmpty: @js(count($data) === 0)
        }" class="col-span-12 lg:col-span-8">

            <!-- Tampilkan jika data kosong -->
            <x-status_pages x-show="isDataEmpty" title="Survei Masih Kosong!!!" style="display: none"
                imgSrc="/hero/3d-business-woman-sitting-sad.png" imgSize="w-44"
                responseText="Aspek dan indikator dalam survei ini masih belum tersedia" showButton="true"
                buttonLink="{{ route('list_survei') }}" />

            <!-- Tampilkan jika survei tidak aktif -->
            <x-status_pages x-show="!isAktif && !isDataEmpty" title="Survei Belum Aktif!!!" style="display: none"
                imgSrc="/hero/3d-business-woman-sitting-sad.png" imgSize="w-44"
                responseText="Saat ini survei belum aktif, tunggu hingga survei diaktifkan" showButton="true"
                buttonLink="{{ route('list_survei') }}" />

            <form wire:submit.prevent="sendSurveiRespon" x-show="$wire.showForm" style="display: none"
                class="w-full flex flex-col gap-y-4 h-fit" x-data="{ sendModal: false, resetModal: false }">
                <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="mb-4">
                        <p class="text-lg font-bold">Biodata Diri</p>
                    </div>
                    <div class="grid grid-cols-12">
                        <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                            <label for="nama" class="text-sm ">Fakultas :</label>
                            <select wire:change="getProdiByFakultas" wire:model="selectedFakultas"
                                class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                <option value="">Semua Fakultas</option>
                                @foreach ($dataFakultas as $fakultas)
                                    <option value="{{ $fakultas->id }}">{{ $fakultas->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (!($dataSurvei->target->name === 'Tenaga Kependidikan'))
                            <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                                <label for="nama" class="text-sm ">Prodi :</label>
                                <select name="prodi_id" wire:model="prodi"
                                    class="p-4 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($dataProdi as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                    @endforeach
                                </select>
                                @error('prodi')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                            <label for="nim" class="text-sm ">NIM :</label>
                            <input type="text" name="nim" wire:model="nim" placeholder="Masukan NIM"
                                class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        </div>
                        <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                            <label for="prodi" class="text-sm ">Prodi :</label>
                            <input type="text" name="prodi" wire:model="prodi" placeholder="Masukan Prodi"
                                class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                        </div> --}}
                    </div>

                </div>
                <div class="p-4 lg:p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="w-full p-4 rounded-lg border mb-6">
                        <div class="w-full inline-flex items-center gap-x-2 text-sm font-semibold mb-4">
                            <span
                                class="w-2 h-2 p-2.5 inline-flex justify-center items-center bg-color-danger-500 rounded-full">
                                <i class="fas fa-exclamation text-white text-xs"></i>
                            </span>
                            Perhatikan!!
                        </div>
                        <div class="w-full text-xs font-semibold mb-4">
                            Lengkapi seluruh bagan survei dengan memilih jawaban: tidak setuju, netral, setuju, atau
                            sangat
                            setuju. Setiap warna tombol pilihan merepresentasikan pilihan tersebut.
                        </div>
                        <div class="w-full grid grid-cols-12">
                            <div
                                class="group hover:cursor-default hover:text-color-danger-500 transition-all duration-300 lg:col-span-3 col-span-12 inline-flex lg:rounded-s-lg items-center border justify-center p-2 gap-x-2 text-xs font-semibold">
                                <span class="p-1 bg-color-danger-500 rounded-full">
                                    <div
                                        class="w-2 h-2 bg-white group-hover:bg-color-danger-500 group-hover:transition-colors group-hover:duration-300 rounded-full">
                                    </div>
                                </span>
                                Tidak Memuaskan
                            </div>
                            <div
                                class="group hover:cursor-default hover:text-color-warning-500 transition-colors duration-300 lg:col-span-3 col-span-12 inline-flex items-center border justify-center p-2 gap-x-2 text-xs font-semibold">
                                <span class="p-1 bg-color-warning-500 rounded-full">
                                    <div
                                        class="w-2 h-2 bg-white group-hover:bg-color-warning-500 group-hover:transition-colors group-hover:duration-300 rounded-full">
                                    </div>
                                </span>
                                Cukup Memuaskan
                            </div>
                            <div
                                class="group hover:cursor-default hover:text-color-success-500 transition-colors duration-300 lg:col-span-3 col-span-12 inline-flex items-center border justify-center p-2 gap-x-2 text-xs font-semibold">
                                <span class="p-1 bg-color-success-500 rounded-full">
                                    <div
                                        class="w-2 h-2 bg-white group-hover:bg-color-success-500 group-hover:transition-colors group-hover:duration-300 rounded-full">
                                    </div>
                                </span>
                                Memuaskan
                            </div>
                            <div
                                class="group hover:cursor-default hover:text-color-info-500 transition-colors duration-300 lg:col-span-3 col-span-12 inline-flex lg:rounded-e-lg items-center border justify-center p-2 gap-x-2 text-xs font-semibold">
                                <span class="p-1 bg-color-info-500 rounded-full">
                                    <div
                                        class="w-2 h-2 bg-white group-hover:bg-color-info-500 group-hover:transition-colors group-hover:duration-300 rounded-full">
                                    </div>
                                </span>
                                Sangat Memuaskan
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($data as $index => $item)
                    <div class="p-4 lg:p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                        <div class="mb-4">
                            <p class="text-lg font-bold">{{ $item[0]->name }}</p>
                        </div>

                        @foreach ($item[1] as $indicatorIndex => $indicator)
                            <fieldset class="grid grid-cols-12 divide-x-2 mb-4 border p-2 rounded-lg items-center">
                                <p class="text-xs lg:text-sm font-semibold col-span-6 lg:col-span-8 p-2 lg:p-4">
                                    {{ $indicator->name }}</p>
                                <div
                                    class="flex items-center justify-between p-2 lg:p-4 col-span-6 lg:col-span-4 text-sm">
                                    <div class="flex flex-col gap-y-1 items-center justify-center">
                                        <label for="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_1"
                                            class="text-color-danger-500 font-bold text-xs">
                                            TM
                                        </label>
                                        <div
                                            class="rounded-full bg-color-danger-500 p-1 flex items-center justify-center">
                                            <input type="radio"
                                                id="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_1"
                                                name="responses[{{ $item[0]->id }}][{{ $indicator->id }}]"
                                                value="1"
                                                wire:model="responses.{{ $item[0]->id }}.{{ $indicator->id }}"
                                                class="w-4 h-4 hover:cursor-pointer">
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-y-1 items-center justify-center">
                                        <label for="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_2"
                                            class="text-color-warning-500 font-bold text-xs">
                                            CM
                                        </label>
                                        <div
                                            class="rounded-full bg-color-warning-500 p-1 flex items-center justify-center">
                                            <input type="radio"
                                                id="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_2"
                                                name="responses[{{ $item[0]->id }}][{{ $indicator->id }}]"
                                                value="2"
                                                wire:model="responses.{{ $item[0]->id }}.{{ $indicator->id }}"
                                                class="w-4 h-4 hover:cursor-pointer">
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-y-1 items-center justify-center">
                                        <label for="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_3"
                                            class="text-color-success-500 font-bold text-xs">
                                            M
                                        </label>
                                        <div
                                            class="rounded-full bg-color-success-500 p-1 flex items-center justify-center">
                                            <input type="radio"
                                                id="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_3"
                                                name="responses[{{ $item[0]->id }}][{{ $indicator->id }}]"
                                                value="3"
                                                wire:model="responses.{{ $item[0]->id }}.{{ $indicator->id }}"
                                                class="w-4 h-4 hover:cursor-pointer">
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-y-1 items-center justify-center">
                                        <label for="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_4"
                                            class="text-color-info-500 font-bold text-xs">
                                            SM
                                        </label>
                                        <div
                                            class="rounded-full bg-color-info-500 p-1 flex items-center justify-center">
                                            <input type="radio"
                                                id="responses[{{ $item[0]->id }}][{{ $indicator->id }}]_4"
                                                name="responses[{{ $item[0]->id }}][{{ $indicator->id }}]"
                                                value="4"
                                                wire:model="responses.{{ $item[0]->ids }}.{{ $indicator->id }}"
                                                class="w-4 h-4 hover:cursor-pointer">
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                        @endforeach
                    </div>
                @endforeach


                <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="flex gap-x-4 items-center">
                        <x-button class="" size="md" color="info" @click="sendModal = !sendModal">
                            Kirim Jawaban
                        </x-button>
                        {{-- tombol reset --}}
                        <div class="border-l-2 inline-flex px-2">
                            <button class="font-bold text-lg text-neutral-500" type="button"
                                @click="resetModal = !resetModal">
                                <span>
                                    <i class="fas fa-redo-alt"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div x-show="resetModal" style="display: none" x-on:keydown.excape.window="resetModal = false"
                    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                    <div class="relative p-4 w-full max-w-md max-h-full" @click.outside="resetModal = false">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" @click="resetModal = false"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="popup-modal">
                                <span>
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 mt-6">Apakah kamu
                                    yakin ingin mereset jawaban survei kamu?</h3>

                                <div class="inline-flex gap-x-2">
                                    <x-button class="" color="primary" size="sm" type="reset"
                                        @click="resetModal = false">
                                        Yakin
                                    </x-button>
                                    <x-button class="" color="primary" size="sm" outlined="true"
                                        @click="resetModal = false">
                                        Batal
                                    </x-button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div x-show="sendModal" style="display: none" x-on:keydown.excape.window="sendModal = false"
                    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                    <div class="relative p-4 w-full max-w-md max-h-full" @click.outside="sendModal = false">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" @click="sendModal = false"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="popup-modal">
                                <span>
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 mt-6">Apakah kamu
                                    yakin ingin mengirim jawban survei kamu?</h3>

                                <div class="inline-flex gap-x-2">
                                    <x-button class="" color="info" size="sm" type="submit">
                                        Yakin
                                    </x-button>
                                    <x-button class="" color="primary" size="sm" outlined="true"
                                        @click="sendModal = false">
                                        Batal
                                    </x-button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>



    </section>
</main>
