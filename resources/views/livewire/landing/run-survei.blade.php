<main class="bg-[#f9fafc] min-h-screen">
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24 grid grid-cols-12 gap-4 pb-12">
        <div
            class="p-8 col-span-4 h-fit bg-white flex flex-col lg:flex-row  gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
            <div class="max-w-lg flex flex-col gap-y-2">
                <h1 class="font-bold text-lg">{{ $survey['name'] }}</h1>
                <p class="text-slate-500 text-sm">{{ $survey['description'] }}</p>
                <div class="flex flex-col gap-y-2 font-semibold">
                    <div class="inline-flex gap-x-2 items-center text-sm">
                        <span>
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <p>Target : {{ $survey['target'] }}</p>
                    </div>
                    <div class="inline-flex gap-x-2 items-center text-sm">
                        <span>
                            <i class="fas fa-server"></i>
                        </span>
                        <p>Jenis Survei : {{ $survey['type'] }}</p>
                    </div>
                    <div class="inline-flex gap-x-2 items-center text-sm text-color-success-500">
                        <span>
                            <i class="fas fa-check"></i>
                        </span>
                        <p>Aspek Total : {{ $survey['aspek_total'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <form wire:submit.prevent="sendSurveiRespon" class="col-span-8 w-full flex flex-col gap-y-4 h-fit"
            x-data="{ sendModal: false, resetModal: false }">
            <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                <div class="mb-4">
                    <p class="text-lg font-bold">Biodata Diri</p>
                </div>
                <div class="grid grid-cols-12">
                    <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                        <label for="nama" class="text-sm ">Nama Lengkap :</label>
                        <input type="text" name="nama" wire:model="nama" placeholder="Masukan Nama Lengkap"
                            class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    </div>
                    <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                        <label for="nim" class="text-sm ">NIM :</label>
                        <input type="text" name="nim" wire:model="nim" placeholder="Masukan NIM"
                            class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    </div>
                    <div class="flex flex-col gap-y-2 col-span-12 mb-4">
                        <label for="prodi" class="text-sm ">Prodi :</label>
                        <input type="text" name="prodi" wire:model="prodi" placeholder="Masukan Prodi"
                            class="p-4 text-sm rounded-md bg-neutral-50 text-slate-800 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    </div>
                </div>
            </div>
            <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                <div class="mb-4">
                    <p class="text-lg font-bold">Aspek Pemersatu Bangsa</p>
                </div>
                <fieldset class="grid grid-cols-12 mb-4">
                    <legend class="font-semibold col-span-12 mb-4">Kemudahan dalam mendapatkan informasi dalam menunjang
                        kegiatan
                        sesuai dengan uraian jabatan serta tugas pokok dan fungsi. (Aspek Tangibles) :</legend>
                    <div class="flex flex-col gap-y-2 col-span-12 text-sm">
                        <label class="flex items-center">
                            <input type="radio" name="aspek_tangibles" value="1" wire:model="responses.1" class="mr-2">
                            Sangat Tidak Setuju
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="aspek_tangibles" value="2"
                                wire:model="responses.aspek_1_indicator_2" class="mr-2">
                            Tidak Setuju
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="aspek_tangibles" value="3" wire:model="responses.3" class="mr-2">
                            Netral
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="aspek_tangibles" value="4" wire:model="responses.4" class="mr-2">
                            Setuju
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="aspek_tangibles" value="5" wire:model="responses.5" class="mr-2">
                            Sangat Setuju
                        </label>
                    </div>
                </fieldset>
            </div>
            <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                <div class="flex gap-x-4 items-center">
                    <x-button class="" size="md" color="primary" @click="sendModal = !sendModal">
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
            <div>
                <div x-show="resetModal" x-transition
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
                                    <x-button class="" color="primary" size="md" type="reset"
                                        @click="resetModal = false">
                                        Yakin
                                    </x-button>
                                    <x-button class="" color="primary" size="md" outlined="true"
                                        @click="resetModal = false">
                                        Batal
                                    </x-button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div x-show="sendModal" x-transition
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
                                    <x-button class="" color="primary" size="md" type="submit">
                                        Yakin
                                    </x-button>
                                    <x-button class="" color="primary" size="md" outlined="true"
                                        @click="sendModal = false">
                                        Batal
                                    </x-button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
</main>