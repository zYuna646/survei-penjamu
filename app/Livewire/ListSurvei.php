<?php

namespace App\Livewire;

use App\Models\Jenis;
use App\Models\Target;
use App\Models\Survey;
use Livewire\Component;
use Livewire\WithPagination;

class ListSurvei extends Component
{
    use WithPagination;

    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $jenis;
    public $target;
    public $filterJenis = '';
    public $filterTarget = '';
    public $search = '';

    public function mount()
    {
        $this->jenis = Jenis::all();
        $this->target = Target::all();
    }

    public function applyFilter()
    {
        $this->resetPage();
        $this->fetchSurveys();
    }

    public function applySearch()
    {
        $this->resetPage();
        $this->fetchSurveys();
    }

    public function fetchSurveys()
    {
        $query = Survey::where('isAktif', true);

        if ($this->filterJenis) {
            $query->where('jenis_id', $this->filterJenis);
        }

        if ($this->filterTarget) {
            $query->where('target_id', $this->filterTarget);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->paginate(6);
    }

    public function render()
    {
        $surveis = $this->fetchSurveys();

        return view('livewire.landing.list-survei', compact('surveis'))
            ->layout('components.layouts.app', [
                'showNavbar' => $this->showNavbar,
                'showFooter' => $this->showFooter,
            ])
            ->title('UNG Survey - List ' . $this->master);
    }
}
