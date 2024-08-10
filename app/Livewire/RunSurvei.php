<?php

namespace App\Livewire;

use App\Models\Survey;
use App\Models\Prodi;
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
    public $dataSurvei;
    public $prodi_id;

    public $prodi;
    public $data;

    public function mount($code)
    {
        $this->dataSurvei = Survey::where('code', $code)->first();
        $this->dataProdi = Prodi::all();
        
        
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

    public function sendSurveiRespon()
    {
        $this->validate([
            'prodi' => 'required',
        ]);
        

        try {            
            DB::beginTransaction();

            $table = [];
            foreach ($this->responses as $index => $aspek) {
                foreach ($aspek as $key => $value) {
                    $table[$key] = $value;
                }
            }
            $table['prodi_id'] = $this->prodi;
            DB::table($this->dataSurvei->id)->insert($table);
            
            $this->isComplete = true;

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Survey Error: ' . $e->getMessage());

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');

            return redirect()->back();
        }
    }

}
