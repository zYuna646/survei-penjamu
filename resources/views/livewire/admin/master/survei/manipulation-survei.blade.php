<main class="bg-[#f9fafc] min-h-screen" x-data="{ activeMenu: 'grafik', userRole: '{{ $userRole }}' }">
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
        <div class="col-span-12 lg:col-span-4 w-full flex flex-col gap-y-4 h-fit">
            <div class="p-8 bg-white flex flex-col lg:flex-row gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
                <div class="max-w-lg flex flex-col gap-y-2">
                    <h1 class="font-bold text-base">{{ $dataSurvei['name'] }}</h1>
                    <div class="flex flex-col gap-y-2 font-semibold">
                        <div class="inline-flex gap-x-2 items-center text-xs">
                            <span><i class="fas fa-bullseye"></i></span>
                            <p>Target : {{ $dataSurvei['target']->name }}</p>
                        </div>
                        <div class="inline-flex gap-x-2 items-center text-xs">
                            <span><i class="fas fa-server"></i></span>
                            <p>Jenis Survei : {{ $dataSurvei['jenis']->name }}</p>
                        </div>
                        <div class="inline-flex gap-x-2 items-center text-xs text-color-success-500">
                            <span><i class="fas fa-check"></i></span>
                            <p>Aspek Total : {{ count($data) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-white flex flex-col lg:flex-row gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
                <div class="flex flex-col gap-y-4 w-full">
                    <h1 class="font-bold text-base">Filter Survei</h1>
                    <form action="" class="w-full flex flex-col gap-y-2">
                        <template x-if="userRole === 'universitas'">
                            <select type="text" name="" wire:model="" placeholder="Semua Jurusan" class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                <option value="">Semua Fakultas</option>
                            </select>
                        </template>
                        <template x-if="userRole === 'universitas' || userRole === 'fakultas'">
                            <select type="text" name="" wire:model="" placeholder="Semua Jurusan" class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                <option value="">Semua Jurusan</option>
                            </select>
                        </template>
                        <template x-if="userRole === 'universitas' || userRole === 'fakultas' || userRole === 'prodi'">
                            <select type="text" name="" wire:model="" placeholder="Semua Jurusan" class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                <option value="">Semua Prodi</option>
                            </select>
                        </template>
                    </form>
                    <x-button class="inline-flex gap-x-2 items-center w-fit" size="md" color="info">
                        <span><i class="fas fa-filter"></i></span>
                        Filter
                    </x-button>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-4 h-fit">
            <div class="flex flex-col gap-y-4">
                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm ">
                    <div class="mb-4">
                        <p class="text-lg font-bold">Jumlah</p>
                    </div>
                    <form action="" class="flex gap-x-2 gap-4 w-full">
                        <input type="text" name="" placeholder="Jumlah Sebenarnya" value="{{ $jumlah }}" disabled
                            class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200" />
                        <input type="text" name="" placeholder="Jumlah" value="{{ $jumlah }}" id="jumlah"
                            class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200" />
                    </form>
                </div>
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
                                    <input type="number" id="tm-{{ $indicator->id }}" placeholder="TM" value="{{ $record[$indicator->id][1] ?? '' }}"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" id="m-{{ $indicator->id }}" placeholder="M" value="{{ $record[$indicator->id][2] ?? '' }}"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" id="cm-{{ $indicator->id }}" placeholder="CM" value="{{ $record[$indicator->id][3] ?? '' }}"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="number" id="sm-{{ $indicator->id }}" placeholder="SM" value="{{ $record[$indicator->id][4] ?? '' }}"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                </div>
                                <div class="lg:col-span-2 col-span-5">
                                    <input type="text" id="sisa-{{ $indicator->id }}" value="{{ $sisa[$indicator->id] ?? '' }}" placeholder="Sisa"
                                        class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200" readonly>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const jumlah = parseFloat(document.getElementById('jumlah').value);

            function updateSisa(indicatorId) {
                const tm = parseFloat(document.getElementById(`tm-${indicatorId}`).value) || 0;
                const m = parseFloat(document.getElementById(`m-${indicatorId}`).value) || 0;
                const cm = parseFloat(document.getElementById(`cm-${indicatorId}`).value) || 0;
                const sm = parseFloat(document.getElementById(`sm-${indicatorId}`).value) || 0;
                const sisa = jumlah - (tm + m + cm + sm);
                document.getElementById(`sisa-${indicatorId}`).value = sisa;
            }

            // Add event listeners to inputs
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', (event) => {
                    const indicatorId = event.target.id.split('-')[1];
                    updateSisa(indicatorId);
                });
            });
        });
    </script>
</main>
