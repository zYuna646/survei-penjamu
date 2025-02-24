<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Survey;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getFakultas()
    {
        try {
            $fakultas = Fakultas::with('prodi')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data fakultas berhasil diambil',
                'data' => $fakultas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProdi()
    {
        try {
            $prodi = Prodi::with('fakultas')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data fakultas berhasil diambil',
                'data' => $prodi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSurvey()
    {
        try {
            $survey = Survey::with('target', 'jenis', 'aspek')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data fakultas berhasil diambil',
                'data' => $survey
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
