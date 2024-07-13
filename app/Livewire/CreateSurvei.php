<?php

namespace App\Livewire;

use App\Models\Aspek;
use App\Models\Indikator;
use App\Models\Survey;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class CreateSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $survei = [];
    public $aspeks = [
        ['name' => '', 'indikators' => [['name' => '']]]
    ];

    protected $rules = [
        'survei.name' => 'required|string|max:255',
        'aspeks.*.name' => 'required|string|max:255',
        'aspeks.*.indikators.*.name' => 'required|string|max:255',
    ]; 

    public function mount($id)
    {
        $survei = Survey::findOrFail($id);
        $this->survei = $survei->toArray();
    }

    public function render()
    {
        return view('livewire.admin.master.survei.create-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Master Survei');
    }

    public function addAspek()
    {
        $survey = Survey::find($this->survei['id']);
        Aspek::create([
            'name ' => '',
            'survey_id' => '',
        ]);
        $this->aspeks[] = ['name' => '', 'indikators' => [['name' => '']]];
    }

    public function removeAspek($index)
    {
        $survey = Survey::find($this->survei['id']);
        $survey->aspek::where('id', $this->aspeks[$index]['id'])->delete();
        unset($this->aspeks[$index]);
        $this->aspeks = array_values($this->aspeks); // reindex array
    }

    public function addIndikator($aspekIndex)
    {
        $aspek = Aspek::find($this->aspeks[$aspekIndex]['id']);
        $indikator = Indikator::create([
            'name' => '',
            'aspek_id' => $aspek->id,
        ]);
        $this->aspeks[$aspekIndex]['indikators'][] = ['name' => ''];
    }

    public function removeIndikator($aspekIndex, $indikatorIndex)
    {
        unset($this->aspeks[$aspekIndex]['indikators'][$indikatorIndex]);
        $this->aspeks[$aspekIndex]['indikators'] = array_values($this->aspeks[$aspekIndex]['indikators']); // reindex array
    }

    public function updateSurvei($surveyId)
    {
        $this->validate();

        // Update the survey record
        $survey = Survey::find($surveyId)->update([
            'name' => $this->survei['name'],
            // Add jenis_id and target_id if needed
        ]);

        // Update the table associated with the survey ID
        Schema::table( $surveyId, function (Blueprint $table) use ($survey) {
            // Drop existing columns
            if (Schema::hasColumn($survey->id, 'jurusan_id')) {
                $table->dropForeign(['jurusan_id']);
                $table->dropColumn('jurusan_id');
            }
    
            foreach ($survey->aspek as $aspek) {
                foreach ($aspek->indicator as $indikator) {
                    if (Schema::hasColumn( $survey->id, $indikator->id)) {
                        $table->dropColumn($indikator->id);
                    }
                }
            }
    
            // Add new columns
            foreach ($survey->aspek as $aspek) {
                foreach ($aspek->indicator as $indikator) {
                    $table->enum($indikator->id, ['1', '2', '3', '4'])->nullable();
                }
            }
    
            // Add jurusan_id column
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
        });

        // Refresh data or redirect as needed
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_survei');
    }
}
