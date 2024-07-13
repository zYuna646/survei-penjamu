<?php

namespace App\Livewire;

use App\Models\Aspek;
use App\Models\Indikator;
use App\Models\Survey;
use App\Models\Target;
use App\Models\Jenis;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class CreateSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $survei;
    public $dataJenis;
    public $dataTarget;
    public $aspeks = [];

    public function mount($id)
    {
        $survei = Survey::findOrFail($id);
        $this->survei = $survei->toArray();
        $this->dataJenis = Jenis::all();
        $this->dataTarget = Target::all();
        $this->loadAspeks();
    }

    public function render()
    {
        return view('livewire.admin.master.survei.create-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Master Survei');
    }

    private function loadAspeks()
    {
        $this->aspeks = Aspek::where('survey_id', $this->survei['id'])
            ->with('indicator')
            ->get()
            ->map(function ($aspek) {
                return [
                    'id' => $aspek->id,
                    'name' => $aspek->name,
                    'indikators' => Indikator::where('aspek_id', $aspek->id )->get()->map(function ($indikator) {
                        return [
                            'id' => $indikator->id,
                            'name' => $indikator->name,
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }

    public function addAspek()
    {
        $aspek = Aspek::create([
            'survey_id' => $this->survei['id'],
            'name' => '',
        ]);
        $this->aspeks[] = [
            'id' => $aspek->id,
            'name' => $aspek->name,
            'indikators' => [],
        ];
    }

    public function removeAspek($aspekIndex)
    {
        $aspek = Aspek::findOrFail($this->aspeks[$aspekIndex]['id']);
        $aspek->delete();
        unset($this->aspeks[$aspekIndex]);
        $this->aspeks = array_values($this->aspeks); // reindex array
    }

    public function addIndikator($aspekIndex)
    {
        $indikator = Indikator::create([
            'aspek_id' => $this->aspeks[$aspekIndex]['id'],
            'name' => '',
        ]);
        $this->aspeks[$aspekIndex]['indikators'][] = [
            'id' => $indikator->id,
            'name' => $indikator->name,
        ];
    }

    public function removeIndikator($aspekIndex, $indikatorIndex)
    {
        $indikator = Indikator::findOrFail($this->aspeks[$aspekIndex]['indikators'][$indikatorIndex]['id']);
        $indikator->delete();
        unset($this->aspeks[$aspekIndex]['indikators'][$indikatorIndex]);
        $this->aspeks[$aspekIndex]['indikators'] = array_values($this->aspeks[$aspekIndex]['indikators']); // reindex array
    }

    public function updateSurvei($surveyId)
    {

        // Update the survey record
        Survey::find($surveyId)->update([
            'name' => $this->survei['name'],
            'jenis_id' => $this->survei['jenis_id'],
            'target_id' => $this->survei['target_id'],
            // Add jenis_id and target_id if needed
        ]);

        foreach ($this->aspeks as $aspek) {
            $aspekModel = Aspek::find($aspek['id']);
            $aspekModel->update(['name' => $aspek['name']]);
    
            foreach ($aspek['indikators'] as $indikator) {
                $indikatorModel = Indikator::find($indikator['id']);
                $indikatorModel->update(['name' => $indikator['name']]);
            }
        }

        $survei = Survey::FindOrFail($this->survei['id']);
        // dd($survei->aspek[0]->indicator);

        // Update the table associated with the survey ID
        Schema::table($survei->id, function (Blueprint $table) use ($survei) {
            // Drop all existing columns
            foreach ($survei->aspek as $aspek) {
                foreach ($aspek->indicator as $indikator) {
                    if (Schema::hasColumn($survei->id, $indikator->id)) {
                        $table->dropColumn($indikator->id);
                    }
                }
            }
            
          
        });

        Schema::table($survei->id, function (Blueprint $table) use ($survei) {
           
            
            // Add new columns
            foreach ($survei->aspek as $aspek) {
                foreach ($aspek->indicator as $indikator) {
                    $table->enum($indikator->id, [1, 2, 3, 4])->nullable();
                }
            }
        });

        return redirect()->to('master_survei');
        // Refresh data or redirect as needed
    }


    public function redirectToAdd()
    {
        return redirect()->to('master_survei');
    }
}
