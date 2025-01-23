<?php

namespace App\Livewire;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use Livewire\Component;

class ManipulationSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $dataSurvei;
    public $data;
    public $jumlah;
    public $record = [];
    public $userRole;
    public $sisa = [];

    public $dataFakultas;
    public $dataJurusan;
    public $dataProdi;

    public $selectedFakultas;
    public $selectedJurusan;
    public $selectedProdi;

    public function mount($id)
    {

        $this->dataFakultas = Fakultas::all();
        $this->dataJurusan = Jurusan::all();
        $this->dataProdi = Prodi::all();
        $this->dataSurvei = Survey::where('id', $id)->first();
        $user = Auth::user();
        $this->userRole = $user->role->slug;
        switch ($user->role->slug) {
            case 'fakultas':
                # code...
                $this->selectedFakultas = $user->fakultas_id;
                $this->getProdiByFakultas();
                break;
            case 'prodi':
                $this->selectedProdi = $user->prodi_id;
                break;
            default:
                # code...
                break;
        }
        $this->getData();
    }

    public function getData()
    {
        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        $record = [];

        if ($this->selectedProdi) {
            $baseQuery = DB::table($this->dataSurvei->id)->where('prodi_id', $this->selectedProdi);
            $this->jumlah = $baseQuery->count();

            foreach ($aspekCollection as $aspek) {
                $data[$aspek->id][0] = $aspek;
                $data[$aspek->id][1] = $aspek->indicator;
                foreach ($aspek->indicator as $indicator) {
                    $tm = DB::table($this->dataSurvei->id)->where('prodi_id', $this->selectedProdi)->where($indicator->id, 1)->count();
                    $cm =  DB::table($this->dataSurvei->id)->where('prodi_id', $this->selectedProdi)->where($indicator->id, 2)->count();
                    $m =  DB::table($this->dataSurvei->id)->where('prodi_id', $this->selectedProdi)->where($indicator->id, 3)->count();
                    $sm =  DB::table($this->dataSurvei->id)->where('prodi_id', $this->selectedProdi)->where($indicator->id, 4)->count();
                    $record[$indicator->id] = [
                        1 => $tm,
                        2 => $cm,
                        3 => $m,
                        4 => $sm,
                    ];
                }
            }
        } else {
            foreach ($aspekCollection as $aspek) {
                $data[$aspek->id][0] = $aspek;
                $data[$aspek->id][1] = $aspek->indicator;

                foreach ($aspek->indicator as $indicator) {
                    $record[$indicator->id] = [
                        1 => 0,
                        2 => 0,
                        3 => 0,
                        4 => 0,
                    ];
                }
            }
            $this->jumlah = 0;
        }

        $this->record = $record;
        $this->data = $data;

        $this->calculateSisa();
    }

    public function updated($field)
    {
        $this->calculateSisa();
    }

    public function getProdiByFakultas()
    {
        if ($this->selectedFakultas) {
            $this->dataProdi = Prodi::where('fakultas_id', $this->selectedFakultas)->get();
        } else {
            $this->dataProdi = [];
            $this->selectedProdi = null;
        }
    }

    public function prodiChanged()
    {
        $this->getData();
    }

    public function prosesForm()
    {
        if (!$this->selectedProdi) {
            dd('Pilih Prodi Terlebih Dahulu');
        }
        // Debugging: Print the current record
        // Get the table name from the survei data
        $table = $this->dataSurvei->id;
        // dd($this->record);

        // Delete all existing records for the selected prodi
        DB::table($table)->where('prodi_id', $this->selectedProdi)->delete();
        // Prepare data for insertion
        // dd($this->record);
        for ($i = 0; $i < $this->jumlah; $i++) {
            $dataToInsert = [];

            foreach ($this->record as $key => $value) {
                $foundIndex = null;

                for ($j = 1; $j <= 4; $j++) {
                    if ((int) $value[$j] > 0) {
                        $foundIndex = $j;
                        $this->record[$key][$j]--;
                        break;
                    }
                }

                if ($foundIndex !== null) {
                    $dataToInsert[$key] = $foundIndex;
                }
            }

            if (!empty($dataToInsert)) {
                $dataToInsert['prodi_id'] = $this->selectedProdi;
                DB::table($table)->insert($dataToInsert);
            }
        }

        return redirect('/detail_survei/' . $this->dataSurvei->id);
    }




    public function calculateSisa()
    {
        foreach ($this->record as $indicatorId => $values) {
            $tm = $values[1] ?? 0;
            $m = $values[2] ?? 0;
            $cm = $values[3] ?? 0;
            $sm = $values[4] ?? 0;

            // Debugging output
            \Log::info("Indicator ID: $indicatorId, TM: $tm, M: $m, CM: $cm, SM: $sm, Total: " . ($tm + $m + $cm + $sm));

            $this->sisa[$indicatorId] = $this->jumlah - ($tm + $m + $cm + $sm);
        }
    }



    public function render()
    {
        return view('livewire.admin.master.survei.manipulation-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Manipulasi Survei' . $this->dataSurvei['name']);
    }
}
