<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditUserProdi extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'User Prodi';

    public $userProdi = [];

    public $dataFakultas = [];
    public $dataJurusan= [];
    public $dataProdi= [];

    protected $rules = [
        'userProdi.name' => 'required|string|max:255',
        'userProdi.fakultas_id' => 'required|exists:fakultas,id',
        'userProdi.jurusan_id' => 'required|exists:jurusans,id',
        'userProdi.prodi_id' => 'required|exists:prodis,id',
        'userProdi.email' => 'required|email|max:255',
        'userProdi.newpass' => 'nullable|min:8',
        'userProdi.password_confirmation' => 'same:userProdi.newpass',
    ];

    public function mount($id)
    {
        $this->userProdi = User::findOrFail($id)->toArray();
        $this->dataFakultas = Fakultas::all(); 
        $this->dataJurusan = Jurusan::where('fakultas_id', $this->userProdi['fakultas_id'])->get();
        $this->dataProdi = Prodi::where('jurusan_id', $this->userProdi['jurusan_id'])->get();
    }

    public function getJurusanByFakultas()
    {
        $fakultasId = $this->userProdi['fakultas_id'];
        $this->dataJurusan = Jurusan::where('fakultas_id', $fakultasId)->get();
        $this->dataProdi = [];
        $this->userProdi['jurusan_id'] = null;
        $this->userProdi['prodi_id'] = null;
    }

    public function getProdiByJurusan()
    {
        $jurusanId = $this->userProdi['jurusan_id'];
        $this->dataProdi = Prodi::where('jurusan_id', $jurusanId)->get();
        $this->userProdi['prodi_id'] = null;
    }

    public function render()
    {
        return view('livewire.admin.pengguna.prodi.edit-user-prodi')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - User Prodi');
    }

    public function updateUserProdi()
    {
        $this->validate();

        $user = User::findOrFail($this->userProdi['id']);

        try{
            DB::beginTransaction();

            $user->update([
                'name' => $this->userProdi['name'],
                'fakultas_id' => $this->userProdi['fakultas_id'],
                'jurusan_id' => $this->userProdi['jurusan_id'],
                'prodi_id' => $this->userProdi['prodi_id'],
                'email' => $this->userProdi['email'],
                'password' => isset($this->userProdi['newpass']) ? bcrypt($this->userProdi['newpass']) : $user->password,
            ]);

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil diedit');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->route('user_prodi');
    }
}

