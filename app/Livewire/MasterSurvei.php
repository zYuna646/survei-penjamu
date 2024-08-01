<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Target;
use App\Models\Jenis;
use App\Models\Survey;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $survei = [
        'nama' => '',
        'jenis_id' => '',
        'target_id' => '',
    ];
    public $indikators = [];

    public $dataSurvei;
    public $dataTarget;
    public $dataJenis;

    public function mount()
    {
        $this->dataSurvei = Survey::all();
        $this->dataTarget = Target::all();
        $this->dataJenis = Jenis::all();

    }

    public function render()
    {
        return view('livewire.admin.master.survei.master-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Survei');
    }
    
    public function addSurvei()
    {
        $this->validate([
            'survei.nama' => 'required|string|max:255',
            'survei.jenis_id' => 'required|exists:jenis,id',
            'survei.target_id' => 'required|exists:targets,id',
        ]);

        $survey = Survey::create([
            'name' => $this->survei['nama'],
            'jenis_id' => $this->survei['jenis_id'],
            'target_id' => $this->survei['target_id'],
            'isAktif' => true,
        ]);

        Schema::create($survey->id, function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
            $table->timestamps();
        }); 

        return redirect()->to('master_survei');
    }

    public function changeSurveiStatus($id)
    {
        $survey = Survey::find($id);
        if ($survey) {
            $survey->isAktif = !$survey->isAktif;
            $survey->save();
        }

        return redirect()->to('master_survei');
    }
    public function deleteSurvei($id)    
    {
        Survey::findOrFail($id)->delete();
        return redirect()->to('master_survei'); 
    }
}
