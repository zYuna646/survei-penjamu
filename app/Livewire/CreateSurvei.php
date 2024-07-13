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

    public function removeIndikator($aspekIndex, $indikatorIndex)
    {
        unset($this->aspeks[$aspekIndex]['indikators'][$indikatorIndex]);
        $this->aspeks[$aspekIndex]['indikators'] = array_values($this->aspeks[$aspekIndex]['indikators']); // reindex array
    }

    public function updateSurvei($surveyId)
    {
        $this->validate();

        // Update the survey record
        Survey::find($surveyId)->update([
            'name' => $this->survei['name'],
            // Add jenis_id and target_id if needed
        ]);

        // Update the table associated with the survey ID
        Schema::table($surveyId, function (Blueprint $table) use ($surveyId) {
            // Drop all existing columns
            $table->dropColumn(array_map(function ($indikator) {
                return $indikator['id'];
            }, $this->aspeks));

            // Add new columns
            foreach ($this->aspeks as $aspek) {
                foreach ($aspek['indikators'] as $indikator) {
                    $table->enum($indikator['id'], [1, 2, 3, 4])->nullable();
                }
            }
        });

        // Refresh data or redirect as needed
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_survei');
    }
}
