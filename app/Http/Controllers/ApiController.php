<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use App\Models\Fakultas;
use App\Models\Indikator;
use App\Models\Prodi;
use App\Models\Survey;
use App\Models\Target;
use App\Models\Temuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenAPI Example",
 *      description="Swagger documentation for Laravel API",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 * )
 */

class ApiController extends Controller
{
    protected $survei;
    protected $selectedFakultas;
    protected $selectedProdi;
    protected $fakultas;
    protected $prodi;
    protected $detail_rekapitulasi;
    protected $detail_rekapitulasi_aspek;
    protected $chartData;
    protected $tabelFakultas;
    protected $tabelProdi;
    protected $dataProdi;
    protected $createDocument;

    /**
     * @OA\Get(
     *      path="/api/target",
     *      operationId="getTarget",
     *      tags={"Target"},
     *      summary="Get list of targets with related surveys",
     *      description="Retrieve all target data along with related surveys",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data target berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Mahasiswa"),
     *                      @OA\Property(
     *                          property="survey",
     *                          type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=10),
     *                              @OA\Property(property="title", type="string", example="Survey Kepuasan Mahasiswa"),
     *                              @OA\Property(property="description", type="string", example="Survey untuk mengukur kepuasan mahasiswa terhadap layanan akademik")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getTarget()
    {
        try {
            $targets = Target::with('survey')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data target berhasil diambil',
                'data' => $targets
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *      path="/api/fakultas",
     *      operationId="getFakultas",
     *      tags={"Fakultas"},
     *      summary="Get list of fakultas with prodi",
     *      description="Retrieve all fakultas along with their associated prodi",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data fakultas berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Fakultas Teknik"),
     *                      @OA\Property(property="code", type="string", example="FT"),
     *                      @OA\Property(
     *                          property="prodi",
     *                          type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=1),
     *                              @OA\Property(property="name", type="string", example="Teknik Informatika"),
     *                              @OA\Property(property="code", type="string", example="TI")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */



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

    /**
     * @OA\Get(
     *      path="/api/fakultas/{id}",
     *      operationId="getFakultasById",
     *      tags={"Fakultas"},
     *      summary="Get fakultas by ID",
     *      description="Retrieve a specific fakultas along with its associated prodi by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of fakultas",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data fakultas berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Fakultas Teknik"),
     *                  @OA\Property(property="code", type="string", example="FT"),
     *                  @OA\Property(
     *                      property="prodi",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="name", type="string", example="Teknik Informatika"),
     *                          @OA\Property(property="code", type="string", example="TI")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Fakultas not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Fakultas tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getFakultasById($id)
    {
        try {
            $fakultas = Fakultas::with('prodi')->find($id);

            if (!$fakultas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fakultas tidak ditemukan'
                ], 404);
            }

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


    /**
     * @OA\Get(
     *      path="/api/prodi",
     *      operationId="getProdi",
     *      tags={"Prodi"},
     *      summary="Get list of all prodi",
     *      description="Retrieve all prodi along with their associated fakultas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data prodi berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Teknik Informatika"),
     *                      @OA\Property(property="code", type="string", example="TI"),
     *                      @OA\Property(
     *                          property="fakultas",
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="name", type="string", example="Fakultas Teknik"),
     *                          @OA\Property(property="code", type="string", example="FT")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getProdi()
    {
        try {
            $prodi = Prodi::with('fakultas')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data prodi berhasil diambil',
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

    /**
     * @OA\Get(
     *      path="/api/prodi/{id}",
     *      operationId="getProdiById",
     *      tags={"Prodi"},
     *      summary="Get prodi by ID",
     *      description="Retrieve a specific prodi along with its associated fakultas by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of prodi",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data prodi berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Teknik Informatika"),
     *                  @OA\Property(property="code", type="string", example="TI"),
     *                  @OA\Property(
     *                      property="fakultas",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Fakultas Teknik"),
     *                      @OA\Property(property="code", type="string", example="FT")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Prodi not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Prodi tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getProdiById($id)
    {
        try {
            $prodi = Prodi::with('fakultas')->find($id);

            if (!$prodi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prodi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data prodi berhasil diambil',
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

    /**
     * @OA\Get(
     *      path="/api/survey",
     *      operationId="getSurvey",
     *      tags={"Survey"},
     *      summary="Get list of all surveys",
     *      description="Retrieve all surveys along with their related target, jenis, and multiple aspek",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data survey berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="title", type="string", example="Survey Kepuasan Mahasiswa"),
     *                      @OA\Property(
     *                          property="target",
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="name", type="string", example="Mahasiswa")
     *                      ),
     *                      @OA\Property(
     *                          property="jenis",
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=2),
     *                          @OA\Property(property="name", type="string", example="Kepuasan")
     *                      ),
     *                      @OA\Property(
     *                          property="aspek",
     *                          type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(property="id", type="integer", example=3),
     *                              @OA\Property(property="name", type="string", example="Pelayanan Akademik")
     *                          )
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */



    public function getSurvey()
    {
        try {
            $survey = Survey::with('target', 'jenis', 'aspek')->get();
            return response()->json([
                'success' => true,
                'message' => 'Data survey berhasil diambil',
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

    /**
     * @OA\Get(
     *      path="/api/survey/{id}",
     *      operationId="getSurveyById",
     *      tags={"Survey"},
     *      summary="Get survey by ID",
     *      description="Retrieve a specific survey along with its related target, jenis, and multiple aspek by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of survey",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data survey berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="title", type="string", example="Survey Kepuasan Mahasiswa"),
     *                  @OA\Property(
     *                      property="target",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Mahasiswa")
     *                  ),
     *                  @OA\Property(
     *                      property="jenis",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(property="name", type="string", example="Kepuasan")
     *                  ),
     *                  @OA\Property(
     *                      property="aspek",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=3),
     *                          @OA\Property(property="name", type="string", example="Pelayanan Akademik")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Survey not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Survey tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getSurveyById($id)
    {
        try {
            $survey = Survey::with('target', 'jenis', 'aspek')->find($id);

            if (!$survey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Survey tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data survey berhasil diambil',
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

    /**
     * @OA\Get(
     *      path="/api/aspek/{id}",
     *      operationId="getAspekById",
     *      tags={"Aspek"},
     *      summary="Get aspek by ID with related indicators",
     *      description="Retrieve a specific aspek along with its indicators",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of aspek",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data aspek berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Pelayanan Akademik"),
     *                  @OA\Property(
     *                      property="indicator",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="id", type="integer", example=1),
     *                          @OA\Property(property="name", type="string", example="Waktu Respons Dosen")
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Aspek not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Aspek tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getAspekById($id)
    {
        try {
            $aspek = Aspek::with('indicator')->find($id);

            if (!$aspek) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aspek tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data aspek berhasil diambil',
                'data' => $aspek
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/indikator/{id}",
     *      operationId="getIndikatorById",
     *      tags={"Indikator"},
     *      summary="Get indikator by ID with related aspek",
     *      description="Retrieve a specific indikator along with its related aspek",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of indikator",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data indikator berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name", type="string", example="Kualitas Pengajaran"),
     *                  @OA\Property(
     *                      property="aspek",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(property="name", type="string", example="Pelayanan Akademik")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Indikator not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Indikator tidak ditemukan")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */

    public function getIndikatorById($id)
    {
        try {
            $indikator = Indikator::with('aspek')->find($id);

            if (!$indikator) {
                return response()->json([
                    'success' => false,
                    'message' => 'Indikator tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data indikator berhasil diambil',
                'data' => $indikator
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/temuan/universitas/{id}",
     *      operationId="getTemuanUniv",
     *      tags={"Temuan"},
     *      summary="Get temuan for university level",
     *      description="Retrieve temuan data that is not associated with any fakultas or prodi based on indikator ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Indikator ID",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data temuan universitas berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="indikator_id", type="integer", example=2),
     *                      @OA\Property(property="temuan", type="string", example="Kekurangan dalam fasilitas akademik"),
     *                      @OA\Property(property="solusi", type="string", example="Meningkatkan pengadaan peralatan laboratorium")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getTemuanUniv($id)
    {
        try {
            $temuan = Temuan::whereNull('prodi_id')
                ->whereNull('fakultas_id')
                ->where('indikator_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data temuan universitas berhasil diambil',
                'data' => $temuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/temuan/fakultas/{id}",
     *      operationId="getTemuanFakultas",
     *      tags={"Temuan"},
     *      summary="Get temuan for faculties",
     *      description="Retrieve temuan data for faculties based on indikator ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Indikator ID",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data temuan fakultas berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="indikator_id", type="integer", example=2),
     *                      @OA\Property(property="fakultas_id", type="integer", example=3),
     *                      @OA\Property(property="temuan", type="string", example="Kurangnya pelatihan untuk dosen"),
     *                      @OA\Property(property="solusi", type="string", example="Mengadakan pelatihan rutin")
     *                  )
     *              )
     *          )
     *      )
     * )
     */


    public function getTemuanFakultas($id)
    {
        try {
            $temuan = Temuan::whereNull('prodi_id')
                ->whereNotNull('fakultas_id')
                ->where('indikator_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data temuan fakultas berhasil diambil',
                'data' => $temuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/temuan/fakultas/{id}/{fakultas_id}",
     *      operationId="getTemuanFakultasById",
     *      tags={"Temuan"},
     *      summary="Get temuan for a specific faculty",
     *      description="Retrieve temuan data for a specific faculty based on indikator ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Indikator ID",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="fakultas_id",
     *          in="path",
     *          required=true,
     *          description="Fakultas ID",
     *          @OA\Schema(type="integer", example=2)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data temuan berdasarkan fakultas berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="indikator_id", type="integer", example=2),
     *                      @OA\Property(property="fakultas_id", type="integer", example=3),
     *                      @OA\Property(property="temuan", type="string", example="Kurangnya sumber daya penelitian"),
     *                      @OA\Property(property="solusi", type="string", example="Menambah anggaran penelitian")
     *                  )
     *              )
     *          )
     *      )
     * )
     */


    public function getTemuanFakultasById($id, $fakultas_id)
    {
        try {
            $temuan = Temuan::where('fakultas_id', $fakultas_id)
                ->where('indikator_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data temuan berdasarkan fakultas berhasil diambil',
                'data' => $temuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/temuan/prodi/{id}",
     *      operationId="getTemuanProdi",
     *      tags={"Temuan"},
     *      summary="Get temuan for programs",
     *      description="Retrieve temuan data for study programs based on indikator ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Indikator ID",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data temuan program studi berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="indikator_id", type="integer", example=2),
     *                      @OA\Property(property="prodi_id", type="integer", example=4),
     *                      @OA\Property(property="temuan", type="string", example="Kurangnya laboratorium penelitian"),
     *                      @OA\Property(property="solusi", type="string", example="Menambah jumlah laboratorium")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */

    public function getTemuanProdi($id)
    {
        try {
            $temuan = Temuan::whereNull('fakultas_id')
                ->whereNotNull('prodi_id')
                ->where('indikator_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data temuan program studi berhasil diambil',
                'data' => $temuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/temuan/prodi/{id}/{prodi_id}",
     *      operationId="getTemuanProdiById",
     *      tags={"Temuan"},
     *      summary="Get temuan for a specific study program",
     *      description="Retrieve temuan data for a specific study program based on indikator ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Indikator ID",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="prodi_id",
     *          in="path",
     *          required=true,
     *          description="Prodi ID",
     *          @OA\Schema(type="integer", example=3)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data temuan berdasarkan program studi berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="indikator_id", type="integer", example=2),
     *                      @OA\Property(property="prodi_id", type="integer", example=3),
     *                      @OA\Property(property="temuan", type="string", example="Kurangnya jumlah dosen tetap"),
     *                      @OA\Property(property="solusi", type="string", example="Merekrut lebih banyak dosen tetap")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Terjadi kesalahan"),
     *              @OA\Property(property="error", type="string", example="Exception error message")
     *          )
     *      )
     * )
     */


    public function getTemuanProdiById($id, $prodi_id)
    {
        try {
            $temuan = Temuan::where('prodi_id', $prodi_id)
                ->where('indikator_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data temuan berdasarkan program studi berhasil diambil',
                'data' => $temuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSurvei($id, $fakultas_id)
    {
        try {
            $this->survei = Survey::with('aspek.indicator')->find($id);
            
            // Set selectedFakultas to null by default
            $this->selectedFakultas = null;
            
            // Only set selectedFakultas if fakultas_id is a valid non-null value
            if ($fakultas_id !== 'null' && $fakultas_id !== null && $fakultas_id !== '') {
                $this->selectedFakultas = Fakultas::find($fakultas_id);
            }
            
            $this->fakultas = Fakultas::where('code', '!=', '0')->get();
            
            // Initialize data arrays to prevent null reference errors
            $this->detail_rekapitulasi = [];
            $this->detail_rekapitulasi_aspek = [];
            $this->chartData = [];
            $this->tabelFakultas = [];
            $this->dataProdi = [];
            
            // Call these methods after setting selectedFakultas to ensure proper filtering
            if ($this->survei) {
                $this->getDetailSurvey();
                $this->calculateTabel();
            } else {
                throw new \Exception("Survey with ID {$id} not found");
            }

            $facultyNames = [];
            $facultyTM = [];
            $facultyCM = [];
            $facultyM = [];
            $facultySM = [];

            // Gather data for faculties based on aspects
            foreach ($this->survei->aspek as $item) {
                $facultyNames[] = $item->name;
                
                // Use the faculty-specific calculation if faculty is selected
                if ($this->selectedFakultas) {
                    $facultyData = $this->calculateFacultySatisfactionDistribution($item->id, $this->selectedFakultas->id);
                } else {
                    $facultyData = $this->calculateFacultySatisfactionDistribution($item->id);
                }
                
                $facultyTM[] = $facultyData['tm'];
                $facultyCM[] = $facultyData['cm'];
                $facultyM[] = $facultyData['m'];
                $facultySM[] = $facultyData['sm'];
            }

            $labels = [];
            $lb = [];
            foreach ($this->survei->aspek as $aspek) {
                $labels[] = $aspek->id;
                foreach ($aspek->indicator as $indicator) {
                    $lb[] = $indicator->id;
                }
            }

            $indicatorValues = [];

            if ($this->survei && $this->survei->aspek) {
                foreach ($this->survei->aspek as $item) {
                    if ($item->indicator) {
                        foreach ($item->indicator as $indi) {
                            if (isset($this->detail_rekapitulasi[$item->id][$indi->id])) {
                                $indicatorValues[] = [
                                    'id' => $indi->id,
                                    'name' => $indi->name,
                                    'nilai_butir' => $this->detail_rekapitulasi[$item->id][$indi->id]['nilai_butir'],
                                    'ikm' => $this->detail_rekapitulasi[$item->id][$indi->id]['ikm'],
                                ];
                            }
                        }
                    }
                }
            }

            usort($indicatorValues, function ($a, $b) {
                return $a['nilai_butir'] <=> $b['nilai_butir'];
            });

            $totalItem = (int) request()->query('total_item', 0);
            $lowestIndicators = $totalItem > 0 ? array_slice($indicatorValues, 0, $totalItem) : $indicatorValues;

            return response()->json([
                'success' => true,
                'message' => 'Data survei berhasil diambil',
                'data' => [
                    'survei' => $this->survei,
                    'faculty_names' => $facultyNames,
                    'faculty_tm' => $facultyTM,
                    'faculty_cm' => $facultyCM,
                    'faculty_m' => $facultyM,
                    'faculty_sm' => $facultySM,
                    'labels' => $labels,
                    'indicator_labels' => $lb,
                    'detail_rekapitulasi' => $this->detail_rekapitulasi,
                    'detail_rekapitulasi_aspek' => $this->detail_rekapitulasi_aspek,
                    'chart_data' => $this->chartData,
                    'tabel_fakultas' => $this->tabelFakultas,
                    'tabel' => $lowestIndicators
                ]
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    private function calculateFacultySatisfactionDistribution($itemId, $selectedFakultasId = null)
    {
        // If a specific faculty is selected, only use that faculty's ID
        if ($selectedFakultasId) {
            $fakultasIds = [$selectedFakultasId];
        } else {
            $fakultasIds = Fakultas::where('code', '!=', '0')->pluck('id');
        }
        
        $prodiIds = Prodi::whereIn('fakultas_id', $fakultasIds)->pluck('id');

        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;
        $totalResponses = 0;

        // Check if we're dealing with an Aspek or a Fakultas
        $aspek = Aspek::with('indicator')->find($itemId);
        
        // If this is an aspek (has indicators)
        if ($aspek && $aspek->indicator && count($aspek->indicator) > 0) {
            foreach ($aspek->indicator as $indicator) {
                try {
                    // Make sure indicator->id exists before querying
                    if ($indicator && $indicator->id) {
                        $query = DB::table($this->survei->id)
                            ->whereIn('prodi_id', $prodiIds);
                        
                        // Use column name as a string, not a number
                        $columnName = (string)$indicator->id;
                        
                        // Check if column exists in the table
                        if (Schema::hasColumn($this->survei->id, $columnName)) {
                            $query = $query->whereNotNull($columnName);
                            $queryResults = $query->get();
                            $totalResponses += count($queryResults);
                            
                            // Sum up TM, CM, M, SM for this indicator
                            $totalTM += $queryResults->where($columnName, 1)->count();
                            $totalCM += $queryResults->where($columnName, 2)->count();
                            $totalM += $queryResults->where($columnName, 3)->count();
                            $totalSM += $queryResults->where($columnName, 4)->count();
                        }
                    }
                } catch (\Exception $e) {
                    // Log error and continue with next indicator
                    continue;
                }
            }
        } else {
            // This is a faculty ID, so calculate for all indicators across all aspects
            foreach ($this->survei->aspek as $aspek) {
                if ($aspek && $aspek->indicator) {
                    foreach ($aspek->indicator as $indicator) {
                        try {
                            // Make sure indicator->id exists before querying
                            if ($indicator && $indicator->id) {
                                $query = DB::table($this->survei->id)
                                    ->whereIn('prodi_id', $prodiIds);
                                
                                // Use column name as a string, not a number
                                $columnName = (string)$indicator->id;
                                
                                // Check if column exists in the table
                                if (Schema::hasColumn($this->survei->id, $columnName)) {
                                    $query = $query->whereNotNull($columnName);
                                    $queryResults = $query->get();
                                    $totalResponses += count($queryResults);
                                    
                                    // Sum up TM, CM, M, SM for this indicator
                                    $totalTM += $queryResults->where($columnName, 1)->count();
                                    $totalCM += $queryResults->where($columnName, 2)->count();
                                    $totalM += $queryResults->where($columnName, 3)->count();
                                    $totalSM += $queryResults->where($columnName, 4)->count();
                                }
                            }
                        } catch (\Exception $e) {
                            // Log error and continue with next indicator
                            continue;
                        }
                    }
                }
            }
        }
        
        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
            'total' => $totalResponses
        ];
    }

    public function getDetailSurvey()
    {
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];

        // Initialize the query
        $table = $this->survei->id; // Assuming the table name is based on survey id
        
        // Make sure table exists before querying
        if (!Schema::hasTable($table)) {
            $this->detail_rekapitulasi = [];
            $this->detail_rekapitulasi_aspek = [];
            return;
        }
        
        $query = DB::table($table); // Start with the query builder

        // Apply filter if a faculty is selected
        if ($this->selectedFakultas) {
            // Filter by selected Fakultas
            $prodiIds = Prodi::where('fakultas_id', $this->selectedFakultas->id)->pluck('id');
            $query->whereIn('prodi_id', $prodiIds);
        }

        // Execute the query and cache the results for better performance
        $queryResults = $query->get();

        // Loop through each Aspek in the survey
        foreach ($this->survei->aspek as $aspek) {
            $avg_tm = [];
            $avg_cm = [];
            $avg_m = [];
            $avg_sm = [];

            // Loop through each Indikator in the Aspek
            foreach ($aspek->indicator as $indicator) {
                try {
                    // Make sure indicator->id exists before querying
                    if ($indicator && $indicator->id) {
                        // Use column name as a string, not a number
                        $columnName = (string)$indicator->id;
                        
                        // Check if column exists 
                        if (!Schema::hasColumn($table, $columnName)) {
                            continue;
                        }
                        
                        // Filter the cached results for this indicator
                        $indicatorResults = $queryResults->whereNotNull($columnName);

                        // Initialize counts for TM, CM, M, SM
                        $tm = $indicatorResults->where($columnName, 1)->count();
                        $cm = $indicatorResults->where($columnName, 2)->count();
                        $m = $indicatorResults->where($columnName, 3)->count();
                        $sm = $indicatorResults->where($columnName, 4)->count();
                        
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
                } catch (\Exception $e) {
                    // Log error and continue with next indicator
                    continue;
                }
            }

            // Calculate the average for the current Aspek if we have data
            if (!empty($avg_tm)) {
                $detail_rekapitulasi_aspek[$aspek->id] = $this->calculateAverageRekapitulasi($avg_tm, $avg_cm, $avg_m, $avg_sm);
            }
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

    public function calculateTabel()
    {
        $fakultasTabel = [];
        $prodiTabel = [];
        $chartData = [];
        
        // If faculty is selected, calculate data only for that faculty
        if ($this->selectedFakultas) {
            $prodiIds = Prodi::where('fakultas_id', $this->selectedFakultas->id)->pluck('id');
            $this->dataProdi = Prodi::whereIn('id', $prodiIds)->get();
            
            foreach ($this->dataProdi as $prodi) {
                $tmp = $this->calculateProdiSatisfactionDistribution($prodi->id);
                $prodiTabel[$prodi->id] = $tmp;
            }
            
            // Calculate chart data for each aspect based on selected faculty
            foreach ($this->survei->aspek as $key => $value) {
                $chartData[] = $this->calculateAspekFaculty($this->selectedFakultas->id, $value->id);
            }
            
            // Calculate faculty table data for just the selected faculty
            $tmp = $this->calculateFacultySatisfactionDistribution($this->selectedFakultas->id, $this->selectedFakultas->id);
            $fakultasTabel[$this->selectedFakultas->id] = $tmp;
        } else {
            // Handle all faculties
            $allFaculties = Fakultas::where('code', '!=', '0')->get();
            
            foreach ($allFaculties as $key => $faculty) {
                $tmp = $this->calculateFacultySatisfactionDistribution($faculty->id);
                $fakultasTabel[$faculty->id] = $tmp;
            }
            
            // Calculate chart data for each aspect across all faculties
            foreach ($this->survei->aspek as $key => $value) {
                $totalTM = 0;
                $totalCM = 0;
                $totalM = 0;
                $totalSM = 0;
                foreach (Aspek::find($value->id)->indicator as $indicator) {
                    $query = DB::table($this->survei->id)->get();

                    // Sum up TM, CM, M, SM for this indicator
                    $totalTM += $query->where($indicator->id, 1)->count();
                    $totalCM += $query->where($indicator->id, 2)->count();
                    $totalM += $query->where($indicator->id, 3)->count();
                    $totalSM += $query->where($indicator->id, 4)->count();
                }
                $chartData[] = $totalTM + $totalCM + $totalM + $totalSM;
            }
        }

        $this->chartData = $chartData;
        $this->tabelFakultas = $fakultasTabel;
        $this->tabelProdi = $prodiTabel;
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

    private function calculateAspekFaculty($facultyId, $aspek_id)
    {
        // Get all program IDs under this faculty
        $prodiIds = Prodi::where('fakultas_id', $facultyId)->pluck('id');

        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;

        // Get all indicators for this aspect
        $aspek = Aspek::with('indicator')->find($aspek_id);
        if ($aspek && $aspek->indicator) {
            foreach ($aspek->indicator as $indicator) {
                try {
                    // Make sure indicator->id exists before querying
                    if ($indicator && $indicator->id) {
                        // Use column name as a string, not a number
                        $columnName = (string)$indicator->id;
                        
                        // Check if column exists in the table
                        if (Schema::hasColumn($this->survei->id, $columnName)) {
                            $query = DB::table($this->survei->id)
                                ->whereIn('prodi_id', $prodiIds)
                                ->whereNotNull($columnName)
                                ->get();

                            // Sum up TM, CM, M, SM for this indicator
                            $totalTM += $query->where($columnName, 1)->count();
                            $totalCM += $query->where($columnName, 2)->count();
                            $totalM += $query->where($columnName, 3)->count();
                            $totalSM += $query->where($columnName, 4)->count();
                        }
                    }
                } catch (\Exception $e) {
                    // Log error and continue with next indicator
                    continue;
                }
            }
        }
        
        return $totalTM + $totalCM + $totalM + $totalSM;
    }





    private function calculateAspekProdi($prodiId, $aspek_id)
    {
        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;

        // Loop through each aspect of the survey
        // Loop through each indicator within the aspect
        foreach (Aspek::find($aspek_id)->indicator as $indicator) {
            $query = DB::table($this->survei->id)
                ->where('prodi_id', $prodiId)
                ->where($indicator->id, '!=', null)->get();

            // Sum up TM, CM, M, SM for this indicator
            $totalTM += $query->where($indicator->id, 1)->count();
            $totalCM += $query->where($indicator->id, 2)->count();
            $totalM += $query->where($indicator->id, 3)->count();
            $totalSM += $query->where($indicator->id, 4)->count();
        }

        return $totalTM + $totalCM + $totalM + $totalSM;
    }

    public function countRespondenByProdi()
    {
        $table = $this->survei->id; // Assuming the table name is based on survey id

        // Start the query without executing it
        $query = DB::table($table);

        // Apply filters only if selections are made
        if ($this->selectedProdi) {
            // Filter by selected Prodi
            $query->where('prodi_id', $this->selectedProdi->id);
        } elseif ($this->selectedFakultas) {
            // Filter by selected Fakultas
            $prodiIds = Prodi::where('fakultas_id', $this->selectedFakultas->id)->pluck('id');
            $query->whereIn('prodi_id', $prodiIds);
        }

        // Execute the query after applying filters
        $queryResult = $query->get();

        // Return the count of results
        return $queryResult->count();
    }

    /**
     * @OA\Get(
     *      path="/api/survei/{id}/prodi/{prodi_id}",
     *      operationId="getSurveiByProdi",
     *      tags={"Survey"},
     *      summary="Get survey data filtered by program study",
     *      description="Retrieve survey data and statistics filtered by specific program study",
     *      @OA\Parameter(
     *          name="id",
     *          description="Survey ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="prodi_id",
     *          description="Program Study ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Data survei berhasil diambil"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Survey or Prodi not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Survey atau Program Studi tidak ditemukan")
     *          )
     *      )
     * )
     */
    public function getSurveiByProdi($id, $prodi_id)
    {
        try {
            $this->survei = Survey::with('aspek.indicator')->find($id);
            
            // Set selectedProdi to null by default
            $this->selectedProdi = null;
            
            // Only set selectedProdi if prodi_id is a valid non-null value
            if ($prodi_id !== 'null' && $prodi_id !== null && $prodi_id !== '') {
                $this->selectedProdi = Prodi::find($prodi_id);
                if (!$this->selectedProdi) {
                    throw new \Exception("Program Studi with ID {$prodi_id} not found");
                }
            }
            
            // Initialize data arrays to prevent null reference errors
            $this->detail_rekapitulasi = [];
            $this->detail_rekapitulasi_aspek = [];
            $this->chartData = [];
            $this->tabelProdi = [];
            
            // Call these methods after setting selectedProdi to ensure proper filtering
            if ($this->survei) {
                $this->getDetailSurvey();
                $this->calculateTabel();
            } else {
                throw new \Exception("Survey with ID {$id} not found");
            }

            $prodiNames = [];
            $prodiTM = [];
            $prodiCM = [];
            $prodiM = [];
            $prodiSM = [];

            // Gather data for program study based on aspects
            foreach ($this->survei->aspek as $item) {
                $prodiNames[] = $item->name;
                
                // Calculate satisfaction distribution for this prodi
                $prodiData = $this->calculateProdiSatisfactionDistribution($this->selectedProdi->id);
                
                $prodiTM[] = $prodiData['tm'];
                $prodiCM[] = $prodiData['cm'];
                $prodiM[] = $prodiData['m'];
                $prodiSM[] = $prodiData['sm'];
            }

            $labels = [];
            $lb = [];
            foreach ($this->survei->aspek as $aspek) {
                $labels[] = $aspek->id;
                foreach ($aspek->indicator as $indicator) {
                    $lb[] = $indicator->id;
                }
            }

            $indicatorValues = [];

            if ($this->survei && $this->survei->aspek) {
                foreach ($this->survei->aspek as $item) {
                    if ($item->indicator) {
                        foreach ($item->indicator as $indi) {
                            if (isset($this->detail_rekapitulasi[$item->id][$indi->id])) {
                                $indicatorValues[] = [
                                    'id' => $indi->id,
                                    'name' => $indi->name,
                                    'nilai_butir' => $this->detail_rekapitulasi[$item->id][$indi->id]['nilai_butir'],
                                    'ikm' => $this->detail_rekapitulasi[$item->id][$indi->id]['ikm'],
                                ];
                            }
                        }
                    }
                }
            }

            usort($indicatorValues, function ($a, $b) {
                return $a['nilai_butir'] <=> $b['nilai_butir'];
            });

            $totalItem = (int) request()->query('total_item', 0);
            $lowestIndicators = $totalItem > 0 ? array_slice($indicatorValues, 0, $totalItem) : $indicatorValues;

            return response()->json([
                'success' => true,
                'message' => 'Data survei berhasil diambil',
                'data' => [
                    'survei' => $this->survei,
                    'prodi_names' => $prodiNames,
                    'prodi_tm' => $prodiTM,
                    'prodi_cm' => $prodiCM,
                    'prodi_m' => $prodiM,
                    'prodi_sm' => $prodiSM,
                    'labels' => $labels,
                    'indicator_labels' => $lb,
                    'detail_rekapitulasi' => $this->detail_rekapitulasi,
                    'detail_rekapitulasi_aspek' => $this->detail_rekapitulasi_aspek,
                    'chart_data' => $this->chartData,
                    'tabel_prodi' => $this->tabelProdi,
                    'tabel' => $lowestIndicators,
                    'total_responden' => $this->countRespondenByProdi()
                ]
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $th->getMessage()
            ], 500);
        }
    }

}
