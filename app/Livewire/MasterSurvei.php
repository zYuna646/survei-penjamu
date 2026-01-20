<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Target;
use App\Models\Jenis;
use App\Models\Survey;
use App\Models\Aspek;
use App\Models\Indikator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    public $userRole;

    public $survei = [
        'nama' => '',
        'jenis_id' => '',
        'target_id' => '',
    ];
    public $indikators = [];

    public $duplicate = [
        'id' => null,
        'name' => '',
    ];

    public $showDuplicateModal = false;

    public $dataSurvei;
    public $dataTarget;
    public $dataJenis;

    public function mount()
    {
        $this->dataSurvei = Survey::all();
        $this->dataTarget = Target::all();
        $this->dataJenis = Jenis::all();

        $user = Auth::user();
        $this->userRole = $user->role->slug;
    }
    

    public function render()
    {
        return view('livewire.admin.master.survei.master-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Master Survei');
    }

    public function addSurvei()
    {
        $this->validate([
            'survei.nama' => 'required|string|max:255',
            'survei.jenis_id' => 'required|exists:jenis,id',
            'survei.target_id' => 'required|exists:targets,id',
        ]);

        try {
            DB::beginTransaction();

            $survey = Survey::create([
                'name' => $this->survei['nama'],
                'jenis_id' => $this->survei['jenis_id'],
                'target_id' => $this->survei['target_id'],
                'isAktif' => true,
            ]);

            DB::commit();

            Schema::create($survey->id, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('prodi_id')->nullable();
                $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
                $table->timestamps();
            });

            session()->flash('toastMessage', 'Data berhasil ditambahkan');
            session()->flash('toastType', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_survei');
    }

    public function prepareDuplicate($id)
    {
        $this->duplicate['id'] = $id;
        $this->duplicate['name'] = '';

        $survey = Survey::find($id);
        if ($survey) {
            $this->duplicate['name'] = $survey->name . ' (Copy)';
        }
    }

    public function openDuplicateModal($id)
    {
        $this->prepareDuplicate($id);
        $this->showDuplicateModal = true;
    }

    public function closeDuplicateModal()
    {
        $this->showDuplicateModal = false;
    }

    public function duplicateSurvei()
    {
        $this->validate([
            'duplicate.id' => 'required|exists:surveys,id',
            'duplicate.name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $source = Survey::with(['aspek.indicator', 'jenis', 'target'])->find($this->duplicate['id']);

            $newSurvey = Survey::create([
                'name' => $this->duplicate['name'],
                'jenis_id' => $source->jenis_id,
                'target_id' => $source->target_id,
                'isAktif' => $source->isAktif,
                'isUpdate' => $source->isUpdate,
            ]);

            foreach ($source->aspek as $aspek) {
                $newAspek = $aspek->replicate();
                $newAspek->survey_id = $newSurvey->id;
                $newAspek->save();

                foreach ($aspek->indicator as $indikator) {
                    $newIndikator = $indikator->replicate();
                    $newIndikator->aspek_id = $newAspek->id;
                    $newIndikator->save();
                }
            }

            DB::commit();

            $newSurvey = Survey::with(['aspek.indicator'])->find($newSurvey->id);

            Schema::dropIfExists($newSurvey->id);
            Schema::create($newSurvey->id, function (Blueprint $table) use ($newSurvey) {
                $table->id();
                $table->timestamps();
                $table->unsignedBigInteger('prodi_id')->nullable();
                $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
                foreach ($newSurvey->aspek as $aspek) {
                    foreach ($aspek->indicator as $indikator) {
                        $table->enum($indikator->id, [1, 2, 3, 4])->nullable();
                    }
                }
            });

            session()->flash('toastMessage', 'Survei berhasil diduplikasi');
            session()->flash('toastType', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_survei');
    }

    public function changeSurveiStatus($id)
    {
        try {
            DB::beginTransaction();

            $survey = Survey::find($id);
            if ($survey) {
                $survey->isAktif = !$survey->isAktif;
                $survey->save();
            }

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil diubah');
            session()->flash('toastType', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_survei');
    }

    public function changeSurveiUpdate($id)
    {
        try {
            DB::beginTransaction();

            $survey = Survey::find($id);
            if ($survey) {
                $survey->isUpdate = !$survey->isUpdate;
                $survey->save();
            }

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil diubah');
            session()->flash('toastType', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_survei');
    }


    public function deleteSurvei($id)
    {
        try {
            DB::beginTransaction();

            Survey::findOrFail($id)->delete();

            DB::commit();

            Schema::dropIfExists($id);

            session()->flash('toastMessage', 'Data berhasil dihapus');
            session()->flash('toastType', 'success');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_survei');
    }
}
