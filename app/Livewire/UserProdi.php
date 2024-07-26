<?php

namespace App\Livewire;
use App\Models\Jurusan;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class UserProdi extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'User Prodi';
    
    public $userProdi = [
        'nama' => '',
        'email' => '',
        'password' => '',
        'prodi_id' => '',
        'jurusan_id' => '',
        'fakultas_id' => '',
    ];
    
    public $dataUserProdi = [];

    public $dataProdi = [];
    public $dataJurusan = [];
    public $dataFakultas;

    public function mount()
    {
        $this->dataFakultas = Fakultas::all();
        $this->dataUserProdi = User::where('role_id', '4')->get();
        // dd($this->dataUserJurusan);
    }
    public function render()
    {
        return view('livewire.admin.pengguna.prodi.user-prodi')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Pengguna Prodi');
    }

    public function getJurusanByFakultas()
    {
        $fakultasId = $this->userProdi['fakultas_id'];
        $this->dataJurusan = Jurusan::where('fakultas_id', $fakultasId)->get();
    }
    public function getProdiByJurusan()
    {
        $jurusanId = $this->userProdi['jurusan_id'];
        $this->dataProdi = Prodi::where('jurusan_id', $jurusanId)->get();
    }

    public function addUserProdi()
    {
        $fakultas = Fakultas::where('code', '0')->first();
        $jurusan = Jurusan::where('code', '0')->first();
        // Validate the input
        $this->validate([
            'userProdi.nama' => 'required|string|max:255',
            'userProdi.email' => 'required|string|email|max:255|unique:users,email',
            'userProdi.password' => 'required|string|min:8',
            'userProdi.fakultas_id' => 'required|exists:fakultas,id',
            'userProdi.jurusan_id' => 'required|exists:jurusans,id',
            'userProdi.prodi_id' => 'required|exists:prodis,id',
        ]);

        try {
            DB::beginTransaction();

            User::create([
                'name' => $this->userProdi['nama'],
                'email' => $this->userProdi['email'],
                'password' => bcrypt($this->userProdi['password']),
                'role_id' => 4,
                'fakultas_id' => $fakultas->id,
                'jurusan_id' => $jurusan->id,
            ]);

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil ditambahkan');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }
        
        return redirect()->to('user_prodi');
    }

    public function deleteUser($id)
    {
        try{
            DB::beginTransaction();

            User::findOrFail($id)->delete();

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil dihapus');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }
        return redirect()->to('user_prodi');
    }
}
