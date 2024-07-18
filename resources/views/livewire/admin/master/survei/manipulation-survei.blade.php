<main class="bg-[#f9fafc] min-h-screen" x-data="{ activeMenu: 'grafik' }">
    <style>
        table,
        th,
        td {
            padding: 8px;
            text-align: center;
            border: 1px solid darkgray;
            border-collapse: collapse;
        }

        table thead {
            background: lightgray;
        }
    </style>
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24 grid grid-cols-12 gap-4 pb-12 ">
        <div
            class="p-6 col-span-12 lg:col-span-4 h-fit bg-white flex flex-col gap-y-2 rounded-lg border border-slate-100 shadow-sm w-full">
            <div class="mb-2">
                <p class="text-lg font-bold">Manipulasi Data Survei</p>
            </div>
            <form wire:submit.prevent="saveManipulation" class="grid grid-cols-12 gap-4">
                <div class="flex flex-col gap-y-2 col-span-6">
                    <input type="number" wire:model="tidakMemuaskan" placeholder="TM"
                        class="p-3 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('tidakMemuaskan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-6">
                    <input type="number" wire:model="cukupMemuaskan" placeholder="CM"
                        class="p-3 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('cukupMemuaskan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-6">
                    <input type="number" wire:model="memuaskan" placeholder="M"
                        class="p-3 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('memuaskan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-6">
                    <input type="number" wire:model="sangatMemuaskan" placeholder="SM"
                        class="p-3 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('sangatMemuaskan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <hr class="col-span-12">
                <div class="flex flex-col gap-y-2 col-span-6">
                    <label for="" class="text-sm">Jumlah :</label>
                    <input type="number" id="jumlah" wire:model="jumlah" placeholder="Jumlah"
                        class="p-3 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                    @error('jumlah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-y-2 col-span-6">
                    <label for="sisa" class="text-sm">Sisa :</label>
                    <input type="number" wire:model="sisa" disabled id="sisa"
                        class="p-3 text-sm rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                </div>
                <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12" color="info" type="submit" >
                    <span wire:loading.remove>
                        <i class="fas fa-check"></i>
                    </span>
                    <span wire:loading class="animate-spin">
                        <i class="fas fa-circle-notch "></i>
                    </span>
                    Simpan
                </x-button>
            </form>
        </div>
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-4 h-fit">
            <div>
                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="mb-2">
                        <p class="text-lg font-bold">Informasi Grafik</p>
                    </div>
                    <div class="text-xs mt-4 overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Instrumen</th>
                                    <th>Tidak Puas</th>
                                    <th>Kurang Puas</th>
                                    <th>Puas</th>
                                    <th>Sangat Puas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Contoh</td>
                                    <td>1</td>
                                    <td>123</td>
                                    <td>12</td>
                                    <td>1256</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>