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

        table tbody tr td.form-td {
            max-width: 60px;
        }

        table tbody tr td.indikator-td {
            width: 120px;
        }

        table thead {
            background: lightgray;
        }
    </style>
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24 grid grid-cols-12 gap-4 pb-12 ">
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
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-4 h-fit">
            <div class="flex flex-col gap-y-4">
                @foreach($data as $index => $item)
                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="mb-4">
                        <p class="text-lg font-bold">{{ $item[0]->name }}</p>
                    </div>
                    @foreach($item[1] as $indicatorIndex => $indicator)
                    <div class="flex flex-col gap-y-4 mb-4">
                        <div class="flex flex-col gap-y-2 border p-4 rounded-md">
                            <div class="flex flex-col">
                                <p class="text-sm">Indikator {{ $loop->iteration }}.</p>
                                <p class="font-bold italic text-sm">{{ $indicator->name }}</p>
                            </div>
                            <div class="grid grid-cols-10 gap-4">
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" wire:model="tidakMemuaskan" placeholder="TM"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" wire:model="tidakMemuaskan" placeholder="M"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" wire:model="tidakMemuaskan" placeholder="CM"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" wire:model="tidakMemuaskan" placeholder="SM"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" wire:model="tidakMemuaskan" placeholder="Sisa"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>