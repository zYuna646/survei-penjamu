<?php

namespace App\Livewire;
use App\Models\Indikator;
use App\Models\Temuan;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class TemuanSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Temuan';


    public $user;
    public $indikator;

    public $dataTemuanUniv = [];
    public $dataTemuanFakultas;
    public $dataTemuanProdi;

    public $temuan;
    public $solusi;

    public function mount($id)
    {
        $this->user = Auth::user();
        $this->indikator = Indikator::FindOrFail($id);
        $this->dataTemuanUniv = Temuan::whereNull('prodi_id')
        ->whereNull('fakultas_id')
        ->where('indikator_id', $id)
        ->get();
        $this->dataTemuanFakultas = Temuan::whereNull('prodi_id')
        ->whereNotNull('fakultas_id')
        ->where('indikator_id', $id)
        ->get();
        $this->dataTemuanProdi = Temuan::whereNull('fakultas_id')
        ->whereNotNull('prodi_id')
        ->where('indikator_id', $id)
        ->get();
    }

    public function addTemuanUniversitas()
    {
        $this->validate([
            'temuan' => 'required'
        ]);

        // dd($this->temuan);  
        
        Temuan::create([
            'indikator_id' => $this->indikator->id,
            'temuan' => $this->temuan
        ]);

        return redirect()->route('temuan_survei', ['id' => $this->indikator->id ]);
    }

    public function addTemuanFakultas()
    {
        $this->validate([
            'temuan' => 'required'
        ]);
        
        Temuan::create([
            'indikator_id' => $this->indikator->id,
            'fakultas_id' => $this->user->fakultas->id,
            'temuan' => $this->temuan
        ]);

        return redirect()->route('temuan_survei', ['id' => $this->indikator->id ]);
    }


    public function addTemuanProdi()
    {
        $this->validate([
            'temuan' => 'required'
        ]);
        
        Temuan::create([
            'indikator_id' => $this->indikator->id,
            'prodi_id' => $this->user->prodi->id,
            'temuan' => $this->temuan
        ]);

        return redirect()->route('temuan_survei', ['id' => $this->indikator->id ]);
    }

    public function addSolusi($id)
    {
        $this->validate([
            'solusi' => 'required'
        ]);

        $selectedTemuan = Temuan::FindOrFail($id);
        
        $selectedTemuan->update([
            'solusi' => $this->solusi,
        ]);

        return redirect()->route('temuan_survei', ['id' => $this->indikator->id ]);
    }

    public function editTemuan($id)
    {

        dd($this->temuan);
        $selectedTemuan = Temuan::FindOrFail($id);
        
        $selectedTemuan->update([
            'temuan' => $this->temuan,
        ]);

        return redirect()->route('temuan_survei', ['id' => $this->indikator->id ]);
    }

    public function deleteTemuan($id)
    {
        $selectedTemuan = Temuan::FindOrFail($id)->delete();
        
        return redirect()->route('temuan_survei', ['id' => $this->indikator->id ]);
    }




    public function render()
    {
        return view('livewire.admin.master.survei.temuan-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Temuan Survei');
    }
    
}
