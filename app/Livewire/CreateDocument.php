<?php

namespace App\Livewire;

use App\Charts\SatisfactionChart;
use App\Models\Aspek;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class CreateDocument extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $createDocument = [];
    public $dataFakultas = [];
    public $dataProdi = [];
    public $dataSurvei = [];
    public $user;
    public $userRole;

    public $survei;
    public $selectedProdi;
    public $selectedFakultas;
    public $detail_rekapitulasi;
    public $detail_rekapitulasi_aspek;
    public $prodi;
    public $fakultas;
    protected $rules = [
        'createDocument.tahun_akademik' => 'required|numeric|min:2000|max:3000',
        'createDocument.tanggal-mulai' => 'required|date',
        'createDocument.tanggal-selesai' => 'required|date',
        // 'createDocument.fakultas_id' => 'required',
        // 'createDocument.prodi_id' => 'required',
        'createDocument.nama_mengetahui' => 'required',
        'createDocument.jabatan_mengetahui' => 'required',
        'createDocument.nip_mengetahui' => 'required',
        'createDocument.nama_penanggung_jawab' => 'required',
        'createDocument.jabatan_penanggung_jawab' => 'required',
        'createDocument.nip_penanggung_jawab' => 'required',
    ];

    public function mount($id)
    {
        $this->dataSurvei = Survey::findOrFail($id);
        $this->survei = Survey::findOrFail($id);
        $this->dataFakultas = Fakultas::all();
        $user = Auth::user();
        $this->userRole = $user->role->slug;
        if ($this->userRole === 'fakultas') {
            $this->dataProdi = Prodi::where('fakultas_id', $user->fakultas_id)->get();
        }
    }

    public function render()
    {
        return view('livewire.admin.master.survei.create-document')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Unduh Dokumen');
    }

    public function getProdiByFakultas()
    {
        $fakultasId = $this->createDocument['fakultas_id'] ?? null;
        $this->dataProdi = $fakultasId ? Prodi::where('fakultas_id', $fakultasId)->get() : [];
    }

    public function downloadDocument(SatisfactionChart $satisfactionChart)
    {
        $this->validate();
        // Render PDF using the updated data
        $this->getDetailSurvey();
        // $this->selectedProdi = Prodi::find($this->createDocument['prodi_id']);
        $this->prodi = Prodi::where('code', '!=', 0)->get();
        $this->fakultas = Fakultas::where('code', '!=', '0')->get();
        $this->user = Auth::user();
        $pdfMerger = PDFMerger::init();

        $facultyNames = [];
        $facultyTM = [];
        $facultyCM = [];
        $facultyM = [];
        $facultySM = [];

        $prodiNames = [];
        $prodiTM = [];
        $prodiCM = [];
        $prodiM = [];
        $prodiSM = [];


        $facultyComparisonChart = $satisfactionChart->buildFacultyComparisonChart($facultyNames, $facultyTM, $facultyCM, $facultyM, $facultySM);


        // Gather data for faculties
        foreach ($this->survei->aspek as $item) {
            $facultyNames[] = $item->name;
            $facultyData = $this->calculateFacultySatisfactionDistribution($item->id);

            $facultyTM[] = $facultyData['tm'];
            $facultyCM[] = $facultyData['cm'];
            $facultyM[] = $facultyData['m'];
            $facultySM[] = $facultyData['sm'];
        }

        $totalRespondenProdi = $this->countRespondenByProdi();
        $tahunAkademik = $this->createDocument['tahun_akademik'];
        $nama_mengetahui = $this->createDocument['nama_mengetahui'];
        $jabatan_mengetahui = $this->createDocument['jabatan_mengetahui'];
        $nip_mengetahui = $this->createDocument['nip_mengetahui'];
        $nama_penanggung_jawab = $this->createDocument['nama_penanggung_jawab'];
        $jabatan_penanggung_jawab = $this->createDocument['jabatan_penanggung_jawab'];
        $nip_penanggung_jawab = $this->createDocument['nip_penanggung_jawab'];
        $tanggalKegiatanMulai = $this->createDocument['tanggal-mulai'];
        $tanggalKegiatanSelesai = $this->createDocument['tanggal-selesai'];

        $chart = Http::get('https://quickchart.io/chart', [
            'c' => json_encode([
                'type' => 'bar',
                'data' => [
                    'labels' => ['January', 'February', 'March', 'April', 'May'],
                    'datasets' => [
                        [
                            'label' => 'indikator',
                            'data' => [120, 150, 180, 200, 170]
                        ]
                    ]
                ]
            ]),
            'format' => 'png',
            'bkg' => 'transparent'
        ]);

        $chartBase64 = base64_encode($chart->body());
        $chartUrl = 'data:image/png;base64,' . $chartBase64;


        $pdfMerger = PDFMerger::init();

        $cover = PDF::loadView('pdf.cover', [
            'survei' => $this->survei,
            'tahunAkademik' => $tahunAkademik,
            'user' => $this->user,
            'prodi' => $this->selectedProdi,
            'fakultas' => $this->selectedFakultas,
        ])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($cover);

        $kata = PDF::loadView('pdf.kata_pengantar', [
            'survei' => $this->survei,
            'nama_mengetahui' => $nama_mengetahui,
            'nip_mengetahui' => $nip_mengetahui,
            'jabatan_mengetahui' => $jabatan_mengetahui,
            'nama_penanggung_jawab' => $nama_penanggung_jawab,
            'jabatan_penanggung_jawab' => $jabatan_penanggung_jawab,
            'nip_penanggung_jawab' => $nip_penanggung_jawab,
        ])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($kata);

        $daftar = PDF::loadView('pdf.daftar_isi', [])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($daftar);

        $bab1 = PDF::loadView('pdf.bab1', [])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($bab1);

        $bab2 = PDF::loadView('pdf.bab2', [
            'fakultas' => Fakultas::where('code', '!=', '0')->get(),
            'prodi' => Prodi::where('code', '!=', '0')->get(),
        ])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($bab2);

        $bab3 = PDF::loadView('pdf.bab3', [
            'chart' => $chartUrl,
            'facultyComparisonChart' => $facultyComparisonChart,
            'detail_rekapitulasi' => $this->detail_rekapitulasi,
            'detail_rekapitulasi_aspek' => $this->detail_rekapitulasi_aspek,
            'tanggalKegiatanMulai' => $this->createDocument['tanggal-mulai'],
            'tanggalKegiatanSelesai' => $this->createDocument['tanggal-selesai'],
            'selectedProdi' => $this->selectedProdi,
            'tingkat' => (Auth::user()->role->slug == 'prodi') ? Auth::user()->prodi->name : ((Auth::user()->role->slug == 'fakultas') ? Auth::user()->fakultas->name : 'Universitas Negeri Gorontalo'),
            'totalRespoondenProdi' => $this->countRespondenByProdi(),
            'survei' => $this->survei,
        ])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($bab3);

        $bab4 = PDF::loadView('pdf.bab4', [
            'facultyComparisonChart' => $facultyComparisonChart,
            'detail_rekapitulasi' => $this->detail_rekapitulasi,
            'detail_rekapitulasi_aspek' => $this->detail_rekapitulasi_aspek,
            // 'tanggalKegiatan' => $this->createDocument['tanggal'],
            'selectedProdi' => $this->selectedProdi,
            'totalRespoondenProdi' => $this->countRespondenByProdi(),
            'survei' => $this->survei,
            'tahunAkademik' => $tahunAkademik,

        ])->setPaper('a4', 'potrait')->output();
        $pdfMerger->addString($bab4);
        $filePath = storage_path('app/public/Laporan_SURVEI_' . $this->survei->name . '.pdf');
        $pdfMerger->merge();
        $pdfMerger->save($filePath);

        // Cek apakah file berhasil dibuat
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
        // // Build charts
        // $pdf = PDF::loadView('pdf.bab4', [
        //     'facultyComparisonChart' => $facultyComparisonChart,
        //     'survei' => $this->survei,
        //     'totalRespoondenProdi' => ,
        //     'prodi' => $this->selectedProdi,
        //     'fakultas' => $this->fakultas,
        //     'tahunAkademik' => $this->createDocument['tahun_akademik'],
        //     'tanggalKegiatan' => $this->createDocument['tanggal'],
        //     'selectedProdi' => $this->selectedProdi,
        //     'detail_rekapitulasi' => $this->detail_rekapitulasi,
        //     'detail_rekapitulasi_aspek' => $this->detail_rekapitulasi_aspek
        // ]);


        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'laporan.pdf');
    }

    private function calculateFacultySatisfactionDistribution($aspekId)
    {

        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;
        $aspek = Aspek::find($aspekId);

        foreach ($aspek->indicator as $indicator) {
            $query = DB::table($this->survei->id)
                ->where('prodi_id', 0)
                ->where($indicator->id, '!=', null)->get();

            // Sum up TM, CM, M, SM for this indicator
            $totalTM += $query->where($indicator->id, 1)->count();
            $totalCM += $query->where($indicator->id, 2)->count();
            $totalM += $query->where($indicator->id, 3)->count();
            $totalSM += $query->where($indicator->id, 4)->count();
        }

        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
        ];
    }

    public function getDetailSurvey()
    {
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];

        // Initialize the query
        $table = $this->survei->id; // Assuming the table name is based on survey id
        $query = DB::table($table); // Start with the query builder

        // Apply filters only if selections are made
        if (Auth::user()->role->slug == 'prodi') {
            // Filter by selected Prodi
            $query->where('prodi_id', Auth::user()->prodi->id);
        } elseif (Auth::user()->role->slug == 'fakultas') {
            // Filter by selected Fakultas
            $prodiIds = Prodi::where('fakultas_id', Auth::user()->fakultas_id)->pluck('id');
            $query->whereIn('prodi_id', $prodiIds);
        }

        // Execute the query
        // $queryResults = $query->get(); // Fetch the results after applying the filters
        // dd($queryResults);
        // Continue with your logic using $queryResults

        // Loop through each Aspek in the survey
        foreach ($this->survei->aspek as $aspek) {
            $avg_tm = [];
            $avg_cm = [];
            $avg_m = [];
            $avg_sm = [];

            // Loop through each Indikator in the Aspek
            foreach ($aspek->indicator as $indicator) {
                // Clone the base query for each indicator
                $indicatorQuery = $query->get();

                // Initialize counts for TM, CM, M, SM
                $tm = $indicatorQuery->where($indicator->id, 1)->count();
                $cm = $indicatorQuery->where($indicator->id, 2)->count();
                $m = $indicatorQuery->where($indicator->id, 3)->count();
                $sm = $indicatorQuery->where($indicator->id, 4)->count();
                // Calculate averages and totals
                $avg_tm[] = $tm;
                $avg_cm[] = $cm;
                $avg_m[] = $m;
                $avg_sm[] = $sm;

                $total = $tm + $cm + $m + $sm;
                if ($total > 0) {
                    $nilai_butir = ($tm * 1 + 2 * $cm + 3 * $m + 4 * $sm) / $total;
                    $ikm = $nilai_butir * 25;

                    $mutu_layanan = $this->getMutuLayanan($nilai_butir);
                    $kinerja_unit = $this->getKinerjaUnit($ikm);
                    $tingkat_kepuasan = $this->getTingkatKepuasan($tm, $cm, $m, $sm, $total);
                    $predikat_kepuasan = $this->getPredikatKepuasan($tingkat_kepuasan);

                    $detail_rekapitulasi[$aspek->id][$indicator->id] = [
                        1 => $tm,
                        2 => $cm,
                        3 => $m,
                        4 => $sm,
                        'total' => $total,
                        'nilai_butir' => number_format($nilai_butir, 2),
                        'ikm' => $ikm,
                        'mutu_layanan' => $mutu_layanan,
                        'kinerja_unit' => $kinerja_unit,
                        'tingkat_kepuasan' => number_format($tingkat_kepuasan * 100, 2),
                        'predikat_kepuasan' => $predikat_kepuasan
                    ];
                } else {
                    $detail_rekapitulasi[$aspek->id][$indicator->id] = [
                        1 => $tm,
                        2 => $cm,
                        3 => $m,
                        4 => $sm,
                        'total' => 0,
                        'nilai_butir' => 0,
                        'ikm' => 0,
                        'mutu_layanan' => 'N/A',
                        'kinerja_unit' => 'N/A',
                        'tingkat_kepuasan' => 0,
                        'predikat_kepuasan' => 'N/A'
                    ];
                }
            }

            // Calculate the average for the current Aspek
            $detail_rekapitulasi_aspek[$aspek->id] = $this->calculateAverageRekapitulasi($avg_tm, $avg_cm, $avg_m, $avg_sm);
        }
        $this->detail_rekapitulasi = $detail_rekapitulasi;
        $this->detail_rekapitulasi_aspek = $detail_rekapitulasi_aspek;
    }

    private function getMutuLayanan($nilai_butir)
    {
        if ($nilai_butir > 3.26) {
            return 'A';
        } elseif ($nilai_butir > 2.51) {
            return 'B';
        } elseif ($nilai_butir > 1.76) {
            return 'C';
        } else {
            return 'D';
        }
    }

    private function getKinerjaUnit($ikm)
    {
        if ($ikm > 81.26) {
            return 'Sangat Baik';
        } elseif ($ikm > 62.51) {
            return 'Baik';
        } elseif ($ikm > 43.76) {
            return 'Kurang Baik';
        } else {
            return 'Tidak Baik';
        }
    }

    private function getTingkatKepuasan($tm, $cm, $m, $sm, $total)
    {
        if ($total == 0) {
            return 0; // Default value or handle as needed
        }
        return (($tm / $total) + (($cm / $total) * 2) + (($m / $total) * 3) + (($sm / $total) * 4)) / 4;
    }

    private function getPredikatKepuasan($tingkat_kepuasan)
    {
        if ($tingkat_kepuasan > 0.75) {
            return 'Sangat Puas';
        } elseif ($tingkat_kepuasan > 0.625) {
            return 'Puas';
        } elseif ($tingkat_kepuasan > 0.50) {
            return 'Cukup Puas';
        } elseif ($tingkat_kepuasan > 0.25) {
            return 'Kurang Puas';
        } else {
            return 'Tidak Puas';
        }
    }

    private function calculateAverageRekapitulasi($avg_tm, $avg_cm, $avg_m, $avg_sm)
    {
        $tm = round(array_sum($avg_tm) / count($avg_tm));
        $cm = round(array_sum($avg_cm) / count($avg_cm));
        $m = round(array_sum($avg_m) / count($avg_m));
        $sm = round(array_sum($avg_sm) / count($avg_sm));
        $total = $tm + $cm + $m + $sm;

        if ($total > 0) {
            $nilai_butir = ($tm * 1 + 2 * $cm + 3 * $m + 4 * $sm) / $total;
            $ikm = $nilai_butir * 25;
        } else {
            $nilai_butir = 0;
            $ikm = 0;
        }

        return [
            1 => $tm,
            2 => $cm,
            3 => $m,
            4 => $sm,
            'total' => $total,
            'nilai_butir' => number_format($nilai_butir, 2),
            'ikm' => $ikm,
            'mutu_layanan' => $this->getMutuLayanan($nilai_butir),
            'kinerja_unit' => $this->getKinerjaUnit($ikm),
            'tingkat_kepuasan' => number_format($this->getTingkatKepuasan($tm, $cm, $m, $sm, $total) * 100, 2),
            'predikat_kepuasan' => $this->getPredikatKepuasan($this->getTingkatKepuasan($tm, $cm, $m, $sm, $total))
        ];
    }
    public function countRespondenByProdi()
    {
        $table = $this->survei->id; // Assuming the table name is based on survey id

        // Start the query without executing it
        $query = DB::table($table);

        // Apply filters only if selections are made
        if (Auth::user()->role->slug == 'prodi') {
            // Filter by selected Prodi
            $query->where('prodi_id', Auth::user()->prodi_id);
        } elseif (Auth::user()->role->slug == 'fakultas') {
            // Filter by selected Fakultas
            $prodiIds = Prodi::where('fakultas_id', Auth::user()->fakultas_id)->pluck('id');
            $query->whereIn('prodi_id', $prodiIds);
        }

        // Execute the query after applying filters
        $queryResult = $query->get();

        // Return the count of results
        return $queryResult->count();
    }
}
