<?php

namespace App\Livewire;

use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Survey;
use Livewire\Component;

class CreateDocument extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $createDocument = [];
    public $dataFakultas = [];
    public $dataProdi = [];
    public $dataSurvei = [];

    protected $rules = [
        'createDocument.tahun_akademik' => 'required|numeric|min:2000|max:3000',
        'createDocument.tanggal' => 'required|date',
        'createDocument.fakultas_id' => 'required',
        'createDocument.prodi_id' => 'required',
    ];

    public function mount($id)
    {
        $this->dataSurvei = Survey::findOrFail($id);
        $this->dataFakultas = Fakultas::all();
    }

    public function render()
    {
        return view('livewire.admin.master.survei.create-document')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Unduh Dokumen');
    }

    public function getProdiByFakultas()
    {
        $fakultasId = $this->createDocument['fakultas_id'] ?? null;
        $this->dataProdi = $fakultasId ? Prodi::where('fakultas_id', $fakultasId)->get() : [];
    }

    public function downloadDocument()
    {
        $this->validate();

        // Simpan data ke session
        session()->put('formData', [
            'tahun_akademik' => $this->createDocument['tahun_akademik'],
            'tanggal' => $this->createDocument['tanggal'],
            'fakultas_id' => $this->createDocument['fakultas_id'],
            'prodi_id' => $this->createDocument['prodi_id'],
        ]);

        // Redirect ke halaman tujuan
        return redirect()->route('laporan_kepuasan');
    }

    
}
