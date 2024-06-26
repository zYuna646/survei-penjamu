<main class="bg-[#f9fafc] min-h-screen">
    <style>
        table,
        th,
        td {
            padding: 8px;
            text-align: center;
            border: 1px solid darkgray;
            border-collapse: collapse;
        }
        table thead{
            background: lightgray;
        }
    </style>
    <section class="max-w-screen-xl w-full mx-auto px-4 pt-24 grid grid-cols-12 gap-4 pb-12 ">
        <div
            class="p-8 col-span-12 lg:col-span-4 h-fit bg-white flex flex-col lg:flex-row  gap-y-2 gap-x-4 rounded-lg border border-slate-100 shadow-sm">
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
                <div class="inline-flex items-center gap-x-2 mt-4">
                    <x-button color="success" size="sm">
                        Download XLS
                    </x-button>
                    <x-button color="danger" size="sm" onclick="window.location.href='{{ route('master_survei') }}'">
                        Kembali
                    </x-button>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-4 h-fit">
            <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                <div class="mb-4">
                    <p class="text-lg font-bold">Grafik Rekapitulasi</p>
                </div>
                <hr>
                <div class="px-2 py-6 bg-white">
                    {!! $chart->container() !!}
                </div>
            </div>
            <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
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
            <div class="p-6  bg-white rounded-lg border-slate-100 shadow-sm flex flex-col">
                <div class="mb-4">
                    <p class="text-lg font-bold">Detail Rekapitulasi</p>
                </div>
                <hr>
                <div class="text-xs mt-4 overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pertanyaan</th>
                                <th>Tidak Puas</th>
                                <th>Kurang Puas</th>
                                <th>Puas</th>
                                <th>Sangat Puas</th>
                                <th>Total Responden</th>
                                <th>Nilai Butir</th>
                                <th>Mutu Layanan</th>
                                <th>Kinerja Unit Pelayanan</th>
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
                                <td>234</td>
                                <td>29423</td>
                                <td>B</td>
                                <td>Baik</td>
                            </tr>
                        </tbody>
                    </table>
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