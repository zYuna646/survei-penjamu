<main class="bg-[#f9fafc] min-h-screen"
    x-data="{ activeMenu: 'grafik', userRole: '{{ $user->role->slug }}', temuanModal: false }">
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
                    <div @click="activeMenu = 'temuan'"
                        :class="{ 'bg-color-info-500 text-white border-color-info-500': activeMenu === 'temuan' }"
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
            <div x-show="activeMenu === 'temuan'" x-cloak>
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
                                    <th>TM</th>
                                    <th>CM</th>
                                    <th>M</th>
                                    <th>SM</th>
                                    <th>Total Rsp</th>
                                    <th>Nilai Butir</th>
                                    <th>Mutu Layanan</th>
                                    <th>Kinerja Unit Pelayanan</th>
                                    <th>Tingkat Kepuasan</th>
                                    <th>Predikat</th>
                                    <th>Temuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aspek->indicator as $index => $item)
                                <tr class="">
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
                                    <td>
                                        <div @click="temuanModal = !temuanModal" wire:click="getTemuan({{ $item->id }})"
                                            class="underline text-color-info-500 hover:cursor-pointer hover:text-color-info-400">
                                            Periksa</div>
                                    </td>
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
                {{-- temuaModal --}}
                <div x-show="temuanModal" style="display: none" x-on:keydown.escape.window="addModal = false"
                    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full max-h-full bg-black/20">
                    <div class="relative p-4 w-full max-w-2xl max-h-full" @click.outside="temuanModal = false">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow ">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                <h3 class="text-lg font-bold text-gray-900 ">
                                    Data Temuan
                                </h3>
                                <button type="button" @click="temuanModal = false"
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
                                <div class="px-2">
                                    <ol class="relative border-s border-gray-200 dark:border-gray-700">
                                        @if ($data_temuan && count($data_temuan) > 0)
                                        @foreach ($data_temuan as $item)
                                        @php
                                        $name = null;
                                        $label = null;
                                        switch (true) {
                                        case !is_null($item->prodi_id) && $item->prodi:
                                        $name = $item->prodi->name;
                                        $label = 'Prodi';
                                        break;
                                        case !is_null($item->fakultas_id) && $item->fakultas:
                                        $name = $item->fakultas->name;
                                        $label = 'Fakultas';
                                        break;
                                        default:
                                        $name = '';
                                        $label = 'Universitas';
                                        break;
                                        }
                                        @endphp
                                        <li class="mb-4 ms-4">
                                            <div
                                                class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700">
                                            </div>
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $label }} {{ $name }}
                                            </h3>
                                            <time
                                                class="mb-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-500">
                                                {{ $item->created_at }}
                                            </time>
                                            <p class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">
                                                {{ $item->temuan }}.
                                            </p>
                                        </li>
                                        @endforeach
                                        @else
                                        <p>No data available.</p>
                                        @endif
                                    </ol>
                                </div>

                                <form wire:submit.prevent="addTemuan" class="grid grid-cols-12 p-2">
                                    <div class="flex flex-col gap-y-2 col-span-12 mb-2">
                                        <label for="temuan" class="text-xs ">Kirim Temuan :</label>
                                        <textarea type="text" id="temuan" name="temuan" wire:model="temuan.temuan"
                                            placeholder="Masukan temuan"
                                            class="p-2 text-xs rounded-md bg-neutral-100 text-slate-600 focus:outline-none focus:outline-color-info-500 border border-neutral-200"></textarea>
                                        @error('temuan.temuan') <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <x-button class="inline-flex items-center w-fit gap-x-2 col-span-12" color="info"
                                        type="submit" size="sm">
                                        <span wire:loading.remove>
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span wire:loading class="animate-spin">
                                            <i class="fas fa-circle-notch "></i>
                                        </span>
                                        Tambah Temuan
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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