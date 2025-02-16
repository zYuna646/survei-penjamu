<?php

namespace App\Livewire;

use App\Models\Survey;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\Fakultas;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RunSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $isComplete = false;
    public $showForm;
    public $master = 'Survei';

    public $responses = [];

    public $dataProdi;
    public $dataJurusan;
    public $dataFakultas;
    public $dataSurvei;
    public $prodi_id;

    public $selectedFakultas;
    public $selectedProdi;

    public $prodi;
    public $data;

    public function mount($code)
    {
        $this->dataSurvei = Survey::where('code', $code)->first();
        $this->dataProdi = Prodi::where('code', '!=', '0')->get();
        $this->dataJurusan = Jurusan::all();
        $this->dataFakultas = Fakultas::all();


        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        foreach ($aspekCollection as $aspek) {
            $data[$aspek->id][0] = $aspek;
            $data[$aspek->id][1] = $aspek->indicator;
        }
        $this->data = $data;

        $this->showForm = !empty($this->data) && $this->dataSurvei->isAktif;
    }

    public function render()
    {
        if ($this->isComplete) {
            return view('livewire.landing.complete-survei', ['dataSurvei' => $this->dataSurvei])
                ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
                ->title('UNG Survey - Result');
        }

        return view('livewire.landing.run-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Survei ' . $this->dataSurvei['name']);
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

    public function sendSurveiRespon()
    {
        // $this->validate([
        //     'prodi' => 'required',
        // ]);
        try {
            DB::beginTransaction();

            $table = [];
            foreach ($this->responses as $index => $aspek) {
                foreach ($aspek as $key => $value) {
                    $table[$key] = $value;
                }
            }

            if (!$this->prodi && $this->dataSurvei->jenis->name !== 'Tenaga Kependidikan') {

                session()->flash('toastMessage', 'Terjadi kesalahan: Prodi Harus DIsi');
            }

            if ($this->dataSurvei->target->name === 'Tenaga Kependidikan') {

                if (!$this->selectedFakultas) {

                    session()->flash('toastMessage', 'Terjadi kesalahan: Fakultas Harus Di isi');

                }
                $prodi = Prodi::where('fakultas_id', $this->selectedFakultas)->where('code', '0')->first();
                $table['prodi_id'] = $prodi->id;

            } else {
                $table['prodi_id'] = $this->prodi;

            }
            DB::table($this->dataSurvei->id)->insert($table);

            $this->isComplete = true;

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            \Log::error('Survey Error: ' . $e->getMessage());

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->back();
        }
    }

}
