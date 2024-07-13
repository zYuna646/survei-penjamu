<?php

namespace App\Livewire;

use App\Models\Survey;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class CreateSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    

    public function render()
    {
        return view('livewire.admin.master.survei.create-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Survei');
    }

    public $survei = ['name' => '']; // This should be initialized with the actual survey name
    public $aspeks = [
        ['name' => '', 'indikators' => [['name' => '']]]
    ];

    public function addAspek()
    {
        $this->aspeks[] = ['name' => '', 'indikators' => [['name' => '']]];
    }

    public function removeAspek($index)
    {
        unset($this->aspeks[$index]);
        $this->aspeks = array_values($this->aspeks); // reindex array
    }

    public function addIndikator($aspekIndex)
    {
        $this->aspeks[$aspekIndex]['indikators'][] = ['name' => ''];
    }

    public function addSurvei()
    {
        $survey = Survey::create([
            'name' => $this->survei['name'],
            'jenis_id' => $this->survei['jenis_id'],
            'target_id' => $this->survei['target_id'],
        ]);
        Schema::create($survey->id, function  (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function removeSurvei($surveyId)
    {
        // Ensure this action is secure and authorized as needed

        // Drop the table associated with the survey ID
        Schema::dropIfExists($surveyId);

        // Optionally, you may also delete the survey record itself
        Survey::find($surveyId)->delete();

        return "Survey and associated table dropped successfully.";
    }


//UPDATE FUNCTION
// public function updateSurvei($surveyId)
// {
//     // Ensure this action is secure and authorized as needed

//     // Update the survey record
//     Survey::find($surveyId)->update([
//         'name' => $this->survei['name'],
//         'jenis_id' => $this->survei['jenis_id'],
//         'target_id' => $this->survei['target_id'],
//     ]);

//     // Update the table associated with the survey ID
//     Schema::table($surveyId, function (Blueprint $table) {
//         foreach ($this->indikator as $key => $value) {
//             $table->dropColumn($value->id);
//         }

//         // Add new columns
//         foreach ($this->indikator as $key => $value) {
//             $table->enum($value->id, [1, 2, 3, 4]->nullable());
//         }
//     });

// }

   

    public function removeIndikator($aspekIndex, $indikatorIndex)
    {
        unset($this->aspeks[$aspekIndex]['indikators'][$indikatorIndex]);
        $this->aspeks[$aspekIndex]['indikators'] = array_values($this->aspeks[$aspekIndex]['indikators']); // reindex array
    }

    protected $rules = [
        'survei.name' => 'required|string|max:255',
        'aspeks.*.name' => 'required|string|max:255',
        'aspeks.*.indikators.*.name' => 'required|string|max:255',
    ];

    public function updateSurvei(){
        dd($this->aspeks);
    }
    public function redirectToAdd()
    {
        return redirect()->to('master_survei');
    }
}
