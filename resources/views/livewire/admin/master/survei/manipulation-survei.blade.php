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
            <div
                class="p-8 bg-white flex flex-col lg:flex-row gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
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
            <div
                class="p-8 bg-white flex flex-col lg:flex-row gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
                <div class="flex flex-col gap-y-4 w-full">
                    <h1 class="font-bold text-base">Filter Survei</h1>
                    <form action="" class="w-full flex flex-col gap-y-2">
                        @if ($userRole === 'universitas')
                            <template x-if="userRole === 'universitas'">
                                <select type="text" name="" wire:model="selectedFakultas"
                                    placeholder="Semua Jurusan" wire:change="getProdiByFakultas"
                                    class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    <option value="">Semua Fakultas</option>
                                    @foreach ($dataFakultas as $fakultas)
                                        <option value="{{ $fakultas->id }}">{{ $fakultas->name }}</option>
                                    @endforeach
                                </select>
                            </template>
                        @endif
                        @if ($userRole === 'universitas' || $userRole === 'fakultas')
                            <template
                                x-if="userRole === 'universitas' || userRole === 'fakultas' || userRole === 'prodi'">
                                <select type="text" name="" wire:model="selectedProdi"
                                    placeholder="Semua Prodi"
                                    class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                    <option value="">Semua Prodi</option>
                                    @foreach ($dataProdi as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                    @endforeach
                                </select>
                            </template>
                        @endif

                    </form>

                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-4 h-fit">
            <form class="flex flex-col gap-y-4" wire:submit.prevent="prosesForm">
                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm">
                    <div class="mb-4">
                        <p class="text-lg font-bold">Jumlah</p>
                    </div>
                    <div class="flex gap-x-2 gap-4 w-full">
                        <div class="w-full">
                            <label for="" class="text-sm">Total :</label>
                            <input type="text" name="total_sebenarnya" placeholder="Jumlah Sebenarnya"
                                value="{{ $jumlah }}" disabled
                                class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200" />
                        </div>
                        <div class="w-full">
                            <label for="" class="text-sm ">Total Ingin Dicapai :</label>
                            <input type="text" name="" placeholder="Jumlah" wire:model='jumlah'
                                value="{{ $jumlah }}" id="jumlah"
                                class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200" />
                        </div>
                    </div>
                </div>
                @foreach ($data as $index => $item)
                    <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                        <div class="mb-4">
                            <p class="text-lg font-bold">{{ $item[0]->name }}</p>
                        </div>
                        @foreach ($item[1] as $indicatorIndex => $indicator)
                            <div class="flex flex-col gap-y-4 mb-4">
                                <div class="flex flex-col gap-y-2 border p-4 rounded-md">
                                    <div class="flex flex-col">
                                        <p class="text-sm">Indikator {{ $loop->iteration }}.</p>
                                        <p class="font-bold italic text-sm">{{ $indicator->name }}</p>
                                    </div>
                                    <div class="grid grid-cols-10 gap-4">
                                        <div class="lg:col-span-2 col-span-5">
                                            <label for="tm-{{ $indicator->id }}" class="text-sm">tm :</label>
                                            <input type="number" id="tm-{{ $indicator->id }}" placeholder="TM"
                                                wire:model="record.{{ $indicator->id }}.1" value="{{ $record[$indicator->id][1] ?? 0 }}"
                                                class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                        </div>
                                        <div class="lg:col-span-2 col-span-5">
                                            <label for="m-{{ $indicator->id }}" class="text-sm">cm :</label>
                                            <input type="number" id="m-{{ $indicator->id }}" placeholder="M"
                                                wire:model="record.{{ $indicator->id }}.2" value="{{ $record[$indicator->id][2] ?? 0 }}"
                                                class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                        </div>
                                        <div class="lg:col-span-2 col-span-5">
                                            <label for="cm-{{ $indicator->id }}" class="text-sm">m :</label>
                                            <input type="number" id="cm-{{ $indicator->id }}" placeholder="CM"
                                                wire:model="record.{{ $indicator->id }}.3" value="{{ $record[$indicator->id][3] ?? 0 }}"
                                                class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                        </div>
                                        <div class="lg:col-span-2 col-span-5">
                                            <label for="sm-{{ $indicator->id }}" class="text-sm">sm :</label>
                                            <input type="number" id="sm-{{ $indicator->id }}" placeholder="SM"
                                                wire:model="record.{{ $indicator->id }}.4" value="{{ $record[$indicator->id][4] ?? 0 }}"
                                                class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                        </div>
                                        <div class="lg:col-span-2 col-span-5">
                                            <label for="sisa-{{ $indicator->id }}" class="text-sm">sisa :</label>
                                            <input type="text" id="sisa-{{ $indicator->id }}" placeholder="Sisa"
                                                value="{{ $sisa[$indicator->id] ?? '' }}" readonly
                                                class="p-2 text-xs w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm flex">
                    <x-button class="" size="md" color="info" type="submit">
                        Kirim Jawaban
                    </x-button>
                </div>
            </form>


        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const jumlahInput = document.getElementById('jumlah');
            let jumlah = parseFloat(jumlahInput.value) || 0;

            function updateSisa(indicatorId) {
                const tm = parseFloat(document.getElementById(`tm-${indicatorId}`).value) || 0;

                const m = parseFloat(document.getElementById(`m-${indicatorId}`).value) || 0;
                const cm = parseFloat(document.getElementById(`cm-${indicatorId}`).value) || 0;
                const sm = parseFloat(document.getElementById(`sm-${indicatorId}`).value) || 0;
                const sisa = jumlah - (tm + m + cm + sm);
                document.getElementById(`sisa-${indicatorId}`).value = sisa;
            }

            function checkAllSisa() {
                let allZero = true;
                document.querySelectorAll('input[id^="sisa-"]').forEach(input => {
                    if (parseFloat(input.value) !== 0) {
                        allZero = false;
                    }
                });
                const submitButton = document.querySelector(
                    'button[type="submit"]'); // Update this selector if needed
                if (submitButton) {
                    submitButton.style.display = allZero ? 'block' : 'none';
                }
            }

            function updateAllSisa() {
                document.querySelectorAll('input[id^="sisa-"]').forEach(input => {
                    const indicatorId = input.id.split('-')[1];
                    updateSisa(indicatorId);
                });
                checkAllSisa();
            }

            // Event listener for changes in jumlah
            jumlahInput.addEventListener('input', () => {
                jumlah = parseFloat(jumlahInput.value) || 0;
                updateAllSisa(); // Recalculate all sisa values
            });

            // Add event listeners to all inputs of type number
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', (event) => {
                    const indicatorId = event.target.id.split('-')[1];
                    updateSisa(indicatorId);
                    checkAllSisa(); // Check if all sisa values are zero
                });
            });

            // Initial check in case sisa values are pre-filled
            updateAllSisa();
        });
    </script>

</main>
