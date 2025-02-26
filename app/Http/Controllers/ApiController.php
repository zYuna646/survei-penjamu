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


}

