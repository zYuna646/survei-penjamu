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

        table thead {
            background: lightgray;
        }
    </style>
    <section class=" max-w-screen-xl w-full mx-auto px-4 pt-24 grid grid-cols-12 gap-4 pb-12 ">
        <div x-data=" { clickCount: 0 }"
            class="p-8 col-span-12 lg:col-span-4 h-fit bg-white flex flex-col lg:flex-row gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm w-full">
            <div class=" flex flex-col gap-y-2 w-full">
                <h1 class="font-bold text-base">{{ $survei['name'] }}</h1>
                {{-- <p class="text-slate-500 text-sm">{{ $survei['description'] }}</p> --}}
                <div class="flex flex-col gap-y-2 font-semibold w-full">
                    <div class="inline-flex gap-x-2 items-center text-xs w-full">
                        <span>
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <p class="w-full">Target : {{ $survei['target']->name }} <span @click="clickCount++"
                                class="cursor-default">.</span>
                        </p>
                    </div>
                    <div class="inline-flex gap-x-2 items-center text-xs">
                        <span>
                            <i class="fas fa-server"></i>
                        </span>
                        <p>Jenis Survei : {{ $survei['jenis']->name }}</p>
                    </div>
                    <div class="inline-flex gap-x-2 items-center text-xs text-color-success-500">
                        <span>
                            <i class="fas fa-check"></i>
                        </span>
                        <p>Aspek Total : {{ count($survei->aspek) }}</p>
                    </div>
                </div>
                <div class="inline-flex items-center gap-x-2 mt-4">
                    <x-button color="danger" size="sm" onclick="window.location.href='{{ route('master_survei') }}'">
                        Kembali
                    </x-button>
                    <template x-if="clickCount >= 2" x-transition>
                        <x-button color="info" size="sm"
                            onclick="window.location.href='{{ route('manipulation_survei', $survei['id']) }}'">
                            Manipulasi Data
                        </x-button>
                    </template>
                </div>
                <hr class="w-full mt-4">
                <div class="mt-2 flex flex-col gap-y-2">
                    <div @click="activeMenu = 'grafik'"
                        :class="{ 'bg-color-info-500 text-white border-color-info-500': activeMenu === 'grafik' }"
                        class="p-3 px-4 border  rounded-lg inline-flex gap-x-2 items-center hover:cursor-pointer transition-colors hover:bg-color-info-400 hover:text-white hover:border-color-info-400">
                        <span class="text-lg">
                            <i class="fas fa-chart-line"></i>
                        </span>
                        <span class="font-semibold text-sm">
                            Grafik Rekapitulasi
                        </span>
                    </div>
                    <div @click="activeMenu = 'tabel'"
                        :class="{ 'bg-color-info-500 text-white border-color-info-500': activeMenu === 'tabel' }"
                        class="p-3 px-4 border  rounded-lg inline-flex gap-x-2 items-center hover:cursor-pointer transition-colors hover:bg-color-info-400 hover:text-white hover:border-color-info-400">
                        <span class="text-lg">
                            <i class="fas fa-server"></i>
                        </span>
                        <span class="font-semibold text-sm">
                            Tabel Rekapitulasi
                        </span>
                    </div>
                    <div @click="activeMenu = 'tabel'"
                        :class="{ 'bg-color-info-500 text-white border-color-info-500': activeMenu === 'tabel' }"
                        class="p-3 px-4 border  rounded-lg inline-flex gap-x-2 items-center hover:cursor-pointer transition-colors hover:bg-color-info-400 hover:text-white hover:border-color-info-400">
                        <span class="text-lg">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <span class="font-semibold text-sm">
                            Temuan
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-4 h-fit">
            <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm ">
                <div class="mb-4">
                    <p class="text-lg font-bold">Filter Data</p>
                </div>
                <form action="" class="flex gap-x-2 gap-4 w-full">
                    <template x-if="userRole === 'universitas'">
                        <select wire:model="selectedFakultas"
                            class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                            <option value="">Semua Fakultas</option>

                        </select>
                    </template>
                    <template x-if="userRole === 'universitas' || userRole === 'fakultas'">
                        <select wire:model="selectedJurusan"
                            class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                            <option value="">Semua Jurusan</option>

                        </select>
                    </template>
                    <template x-if="userRole === 'universitas' || userRole === 'fakultas' || userRole === 'prodi'">
                        <select wire:model="selectedProdi"
                            class="p-3 text-sm w-full rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200">
                            <option value="">Semua Prodi</option>
                        </select>
                    </template>

                </form>
            </div>
            <div x-show="activeMenu === 'grafik'" x-cloak>
                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="mb-4">
                        <p class="text-lg font-bold">Grafik Rekapitulasi</p>
                    </div>
                    <hr>
                    <div class="px-2 py-6 bg-white">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
            <div x-show="activeMenu === 'tabel'" x-cloak>
                <div class="p-6 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="mb-4">
                        <p class="text-lg font-bold">Informasi Grafik</p>
                    </div>
                    <hr>
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
                @foreach ($survei->aspek as $aspek)
                <div class="p-6 mt-2 bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                    <div class="mb-4">
                        <p class="text-lg font-bold">{{ $aspek->name }}</p>
                    </div>
                    <div class="text-xs mt-2 overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pertanyaan</th>
                                    <th>Tidak Memuaskan</th>
                                    <th>Cukup Memuaskan</th>
                                    <th>Memuaskan</th>
                                    <th>Sangat Memuaskan</th>
                                    <th>Total Responden</th>
                                    <th>Nilai Butir</th>
                                    <th>Mutu Layanan</th>
                                    <th>Kinerja Unit Pelayanan</th>
                                    <th>Tingkat Kepuasan</th>
                                    <th>Predikat Tingkat Kepuasan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aspek->indicator as $index => $item)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']][1]}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']][2]}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']][3]}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']][4]}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']]['total']}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']]['nilai_butir']}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']]['mutu_layanan']}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']]['kinerja_unit']}}</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']]['tingkat_kepuasan'] }}%</td>
                                    <td>{{$detail_rekapitulasi[$aspek->id][$item['id']]['predikat_kepuasan']}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td class="font-bold">Total Rerata Penilaian Aspek</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id][1]}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id][2]}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id][3]}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id][4]}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id]['total']}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id]['nilai_butir']}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id]['mutu_layanan']}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id]['kinerja_unit']}}</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id]['tingkat_kepuasan'] }}%</td>
                                    <td>{{$detail_rekapitulasi_aspek[$aspek->id]['predikat_kepuasan']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @push('scripts')
    <script>
        $(document).ready(function() {
                // Inisialisasi DataTables
                var table = $('.myTable').DataTable();
            });
    </script>
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    @endpush
</main>