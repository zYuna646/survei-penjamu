<?php

namespace App\Livewire;

use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;

class CreateDocument extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $createDocument = [];
    public $dataFakultas = [];
    public $dataProdi = [];
    public $dataSurvei = [];

    public $survei;
    public $selectedProdi;
    public $selectedFakultas;
    public $detail_rekapitulasi;
    public $detail_rekapitulasi_aspek;
    protected $rules = [
        'createDocument.tahun_akademik' => 'required|numeric|min:2000|max:3000',
        'createDocument.tanggal' => 'required|date',
        'createDocument.fakultas_id' => 'required',
        'createDocument.prodi_id' => 'required',
    ];

    public function mount($id)
    {
        $this->dataSurvei = Survey::findOrFail($id);
        $this->survei = Survey::findOrFail($id);
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
        $data = [
            'survei' => $this->dataSurvei->id,
            'selectedProdi' => $this->createDocument['prodi_id'],
            'tahunAkademik' => $this->createDocument['tahun_akademik'],
            'tanggalKegiatan' => $this->createDocument['tanggal']
        ];

        return redirect()->route('laporan_kepuasan', [
            'survei' => $data['survei'],
            'prodi' => $data['selectedProdi'],
            'tahunAkademik' => $data['tahunAkademik'],
            'tanggalKegiatan' => $data['tanggalKegiatan']
        ]);
    }


  
}
