<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Survey;
use DB;
use Illuminate\Http\Request;

class ApiSurveyController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/survey/{id}/detail",
 *     summary="Retrieve detailed survey results",
 *     description="Mengambil detail survey berdasarkan ID, termasuk rekapitulasi hasil per aspek dan indikator. Filter opsional dapat diterapkan menggunakan query parameter prodi_id atau fakultas_id.",
 *     tags={"Survey"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID dari survey",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Parameter(
 *         name="prodi_id",
 *         in="query",
 *         description="Filter opsional berdasarkan ID program studi",
 *         required=false,
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *     @OA\Parameter(
 *         name="fakultas_id",
 *         in="query",
 *         description="Filter opsional berdasarkan ID fakultas",
 *         required=false,
 *         @OA\Schema(type="integer", example=3)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Data survey dan rekapitulasi berhasil diambil",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Data survey berhasil diambil"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(
 *                     property="survey",
 *                     type="object",
 *                     description="Detail survey",
 *                     example={"id":1, "name":"Survey Kepuasan Mahasiswa", "target":{}, "jenis":{}, "aspek":{}}
 *                 ),
 *                 @OA\Property(
 *                     property="rekapitulasi",
 *                     type="object",
 *                     description="Hasil rekapitulasi per aspek dan indikator, diindeks berdasarkan ID aspek dan ID indikator",
 *                     example={
 *                         "1": {
 *                             "101": {
 *                                 "tm": 5,
 *                                 "cm": 3,
 *                                 "m": 7,
 *                                 "sm": 2,
 *                                 "total": 17,
 *                                 "nilai_butir": "2.65",
 *                                 "ikm": 66.25,
 *                                 "mutu_layanan": "B",
 *                                 "kinerja_unit": "Baik",
 *                                 "tingkat_kepuasan": "65.00",
 *                                 "predikat_kepuasan": "Puas"
 *                             }
 *                         }
 *                     }
 *                 ),
 *                 @OA\Property(
 *                     property="rekapitulasi_aspek",
 *                     type="object",
 *                     description="Rata-rata rekapitulasi per aspek, diindeks berdasarkan ID aspek",
 *                     example={
 *                         "1": {
 *                             "tm": 5,
 *                             "cm": 3,
 *                             "m": 7,
 *                             "sm": 2,
 *                             "total": 17,
 *                             "nilai_butir": "2.65",
 *                             "ikm": 66.25,
 *                             "mutu_layanan": "B",
 *                             "kinerja_unit": "Baik",
 *                             "tingkat_kepuasan": "65.00",
 *                             "predikat_kepuasan": "Puas"
 *                         }
 *                     }
 *                 ),
 *                 @OA\Property(
 *                     property="lowestIndicator",
 *                     type="array",
 *                     description="Lima indikator dengan nilai butir terendah",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="aspek_id", type="integer", example=1),
 *                         @OA\Property(property="indicator_id", type="integer", example=101),
 *                         @OA\Property(property="nilai_butir", type="number", format="float", example=2.65),
 *                         @OA\Property(
 *                             property="detail",
 *                             type="object",
 *                             description="Detail perhitungan indikator",
 *                             example={
 *                                 "tm": 5,
 *                                 "cm": 3,
 *                                 "m": 7,
 *                                 "sm": 2,
 *                                 "total": 17,
 *                                 "nilai_butir": "2.65",
 *                                 "ikm": 66.25,
 *                                 "mutu_layanan": "B",
 *                                 "kinerja_unit": "Baik",
 *                                 "tingkat_kepuasan": "65.00",
 *                                 "predikat_kepuasan": "Puas"
 *                             }
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Survey tidak ditemukan",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Survey tidak ditemukan")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Terjadi kesalahan pada server",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
 *             @OA\Property(property="error", type="string", example="Detail error message")
 *         )
 *     )
 * )
 */




    public function getSurveyDetailById($id, Request $request)
    {
        try {
            $survey = Survey::with('target', 'jenis', 'aspek.indicator')->find($id);

            if (!$survey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Survey tidak ditemukan'
                ], 404);
            }

            $prodi_id = $request->query('prodi_id');
            $fakultas_id = $request->query('fakultas_id');

            $detail_rekapitulasi = [];
            $detail_rekapitulasi_aspek = [];

            $table = $survey->id;
            $query = DB::table($table);

            if ($prodi_id) {
                $query->where('prodi_id', $prodi_id);
            } elseif ($fakultas_id) {
                $prodiIds = Prodi::where('fakultas_id', $fakultas_id)->pluck('id');
                $query->whereIn('prodi_id', $prodiIds);
            }

            foreach ($survey->aspek as $aspek) {
                $avg_tm = [];
                $avg_cm = [];
                $avg_m = [];
                $avg_sm = [];

                foreach ($aspek->indicator as $indicator) {
                    $indicatorQuery = $query->get();

                    $tm = $indicatorQuery->where($indicator->id, 1)->count();
                    $cm = $indicatorQuery->where($indicator->id, 2)->count();
                    $m = $indicatorQuery->where($indicator->id, 3)->count();
                    $sm = $indicatorQuery->where($indicator->id, 4)->count();

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
                            'tm' => $tm,
                            'cm' => $cm,
                            'm' => $m,
                            'sm' => $sm,
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
                            'tm' => $tm,
                            'cm' => $cm,
                            'm' => $m,
                            'sm' => $sm,
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
                $detail_rekapitulasi_aspek[$aspek->id] = $this->calculateAverageRekapitulasi($avg_tm, $avg_cm, $avg_m, $avg_sm);
            }

            $allIndicators = [];
            foreach ($detail_rekapitulasi as $aspekId => $indicators) {
                foreach ($indicators as $indicatorId => $data) {
                    if (isset($data['nilai_butir'])) {
                        $allIndicators[] = [
                            'aspek_id' => $aspekId,
                            'indicator_id' => $indicatorId,
                            'nilai_butir' => floatval($data['nilai_butir']),
                            'detail' => $data
                        ];
                    }
                }
            }

            usort($allIndicators, function ($a, $b) {
                return $a['nilai_butir'] <=> $b['nilai_butir'];
            });

            $lowestIndicators = array_slice($allIndicators, 0, 5);

            return response()->json([
                'success' => true,
                'message' => 'Data survey berhasil diambil',
                'data' => [
                    'survey' => $survey,
                    'rekapitulasi' => $detail_rekapitulasi,
                    'rekapitulasi_aspek' => $detail_rekapitulasi_aspek,
                    'lowestIndicator' => $lowestIndicators
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getDetailSurvey()
    {
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];

        // Initialize the query
        $table = $this->survei->id; // Assuming the table name is based on survey ID
        $query = DB::table($table);

        // Apply filters based on selections
        if ($this->selectedProdi) {
            $query->where('prodi_id', $this->selectedProdi);
        } elseif ($this->selectedFakultas) {
            $prodiIds = Prodi::where('fakultas_id', $this->selectedFakultas)->pluck('id');
            $query->whereIn('prodi_id', $prodiIds);
        }

        // Loop through each Aspek in the survey
        foreach ($this->survei->aspek as $aspek) {
            $avg_tm = [];
            $avg_cm = [];
            $avg_m = [];
            $avg_sm = [];

            // Loop through each Indikator in the Aspek
            foreach ($aspek->indicator as $indicator) {
                $indicatorQuery = $query->get();

                // Initialize counts for TM, CM, M, SM
                $tm = $indicatorQuery->where($indicator->id, 1)->count();
                $cm = $indicatorQuery->where($indicator->id, 2)->count();
                $m = $indicatorQuery->where($indicator->id, 3)->count();
                $sm = $indicatorQuery->where($indicator->id, 4)->count();
                // Store the counts for averaging
                $avg_tm[] = $tm;
                $avg_cm[] = $cm;
                $avg_m[] = $m;
                $avg_sm[] = $sm;

                // Calculate totals and avoid division by zero
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
                    // Handle case where no responses are available
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

        // Store results for later use
        $this->detail_rekapitulasi = $detail_rekapitulasi;
        $this->detail_rekapitulasi_aspek = $detail_rekapitulasi_aspek;
        $this->calculateTabel();
    }
    private function getLowest()
    {
        // Initialize an array to hold all indicators with their 'nilai_butir' values
        $allIndicators = [];

        // Iterate through aspects and indicators
        foreach ($this->survei->aspek as $aspek) {
            foreach ($aspek->indicator as $indicator) {
                // Ensure 'nilai_butir' is set and valid
                $nilaiButir = $this->detail_rekapitulasi[$aspek->id][$indicator->id]['nilai_butir'] ?? null;

                if ($nilaiButir !== null) {
                    // Add indicator details to the array
                    $allIndicators[] = [
                        'name' => $indicator->name,
                        'nilai_butir' => $nilaiButir,
                        'aspek_id' => $aspek->id,
                        'aspek_name' => $aspek->name,
                        'indicator_id' => $indicator->id,
                        'detail_rekapitulasi' => $this->detail_rekapitulasi[$aspek->id][$indicator->id]
                    ];
                }
            }
        }

        // Sort the indicators by 'nilai_butir' in ascending order
        usort($allIndicators, function ($a, $b) {
            return $a['nilai_butir'] <=> $b['nilai_butir'];
        });

        // Limit to the 5 lowest values
        $lowestIndicators = array_slice($allIndicators, 0, 5);

        // Return the results
        $this->lowestIndicator = $lowestIndicators;
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

    public function getProdiByFakultas()
    {
        if ($this->selectedFakultas) {
            $this->dataProdi = Prodi::where('fakultas_id', $this->selectedFakultas)->get();
            $this->getDetailSurvey();
        } else {
            $this->dataProdi = [];
            $this->selectedProdi = null;
            $this->getDetailSurvey();
        }
        $this->calculateTabel();
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


    public function calculateTabel()
    {
        $fakultasTabel = [];
        $prodiTabel = [];

        // Ottieni tutti i dati necessari da una singola query (se possibile)

        foreach ($this->dataFakultas as $fakultas) {
            $tmp = $this->calculateFacultySatisfactionDistribution($fakultas->id);
            $fakultasTabel[$fakultas->id] = $tmp;
        }

        foreach ($this->dataProdi as $prodi) {
            $tmp = $this->calculateProdiSatisfactionDistribution($prodi->id);
            $prodiTabel[$prodi->id] = $tmp;
        }

        // dd($fakultasTabel);
        // dd($prodiTabel);

        $this->tabelFakultas = $fakultasTabel;
        $this->tabelProdi = $prodiTabel;
    }

    private function calculateFacultySatisfactionDistribution($facultyId)
    {
        $fakultasIds = Fakultas::where('id', $facultyId)->pluck('id');
        $prodiIds = Prodi::whereIn('fakultas_id', $fakultasIds)->pluck('id');

        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;

        // Loop through each aspect of the survey
        foreach ($this->survei->aspek as $aspek) {
            // Loop through each indicator within the aspect
            foreach ($aspek->indicator as $indicator) {
                $query = DB::table($this->survei->id)
                    ->whereIn('prodi_id', $prodiIds)
                    ->where($indicator->id, '!=', null)->get();

                // Sum up TM, CM, M, SM for this indicator
                $totalTM += $query->where($indicator->id, 1)->count();
                $totalCM += $query->where($indicator->id, 2)->count();
                $totalM += $query->where($indicator->id, 3)->count();
                $totalSM += $query->where($indicator->id, 4)->count();
            }
        }
        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
            'total' => $query->count()
        ];
    }


    private function calculateProdiSatisfactionDistribution($prodiId)
    {
        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;

        // Loop through each aspect of the survey
        foreach ($this->survei->aspek as $aspek) {
            // Loop through each indicator within the aspect
            foreach ($aspek->indicator as $indicator) {
                $query = DB::table($this->survei->id)
                    ->where('prodi_id', $prodiId)
                    ->where($indicator->id, '!=', null)->get();

                // Sum up TM, CM, M, SM for this indicator
                $totalTM += $query->where($indicator->id, 1)->count();
                $totalCM += $query->where($indicator->id, 2)->count();
                $totalM += $query->where($indicator->id, 3)->count();
                $totalSM += $query->where($indicator->id, 4)->count();
            }
        }

        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
            'total' => $query->count()
        ];
    }

}
