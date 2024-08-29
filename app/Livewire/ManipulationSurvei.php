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
        $this->dataSurvei = Survey::where('id', $id)->first();
        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        $record = [];
        foreach ($aspekCollection as $aspek) {
            $data[$aspek->id][0] = $aspek;
            $data[$aspek->id][1] = $aspek->indicator;
            foreach ($aspek->indicator as $indicator) {
                $tmp = [
                    1 => DB::table($this->dataSurvei->id)->where($indicator->id, 1)->count(),
                    2 => DB::table($this->dataSurvei->id)->where($indicator->id, 2)->count(),
                    3 => DB::table($this->dataSurvei->id)->where($indicator->id, 3)->count(),
                    4 => DB::table($this->dataSurvei->id)->where($indicator->id, 4)->count(),
                ];
                $record[$indicator->id] = $tmp;
            }
        }
        $this->jumlah = DB::table($this->dataSurvei->id)->count();
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

    public function prosesForm()
    {
        if (!$this->selectedProdi) {
            dd('Pilih Prodi Terlebih Dahulu');
        }
        // Debugging: Print the current record
        // Get the table name from the survei data
        $table = $this->dataSurvei->id;

        // Delete all existing records for the selected prodi
        DB::table($table)->where('prodi_id', $this->selectedProdi)->delete();
        // Prepare data for insertion
        for ($i = 0; $i < $this->jumlah; $i++) {
            $dataToInsert = [];
            foreach ($this->record as $key => $value) {
                for ($j = 1; $j <= 4; $j++) {
                    if ($value[$j] != 0) {

                        $dataToInsert[$key] = $j;
                        $value[$j] = $value[$j] - 1; // Adjust the value
                        break;
                    }
                }
            }
            $dataToInsert['prodi_id'] = $this->selectedProdi;
            // Insert the data into the table
            DB::table($table)->insert($dataToInsert);
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
