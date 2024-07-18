<?php

namespace App\Livewire;
use App\Models\Jurusan;
use App\Models\Fakultas;
use App\Models\User;
use Livewire\Component;

class UserJurusan extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'User Jurusan';
    
    public $userJurusan = [
        'nama' => '',
        'email' => '',
        'password' => '',
        'jurusan_id' => '',
        'fakultas_id' => '',
    ];
    
    public $dataUserJurusan = [];

    public $dataJurusan = [];
    public $dataFakultas;

    public function mount()
    {
        $this->dataFakultas = Fakultas::all();
        $this->dataUserJurusan = User::where('role_id', '3')->get();
        // dd($this->dataUserJurusan);
    }
    public function render()
    {
        return view('livewire.admin.pengguna.jurusan.user-jurusan')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Pengguna Jurusan');
    }

    public function getJurusanByFakultas()
    {
        $fakultasId = $this->userJurusan['fakultas_id'];
        $this->dataJurusan = Jurusan::where('fakultas_id', $fakultasId)->get();
    }

    public function addUserJurusan()
    {
        $fakultas = Fakultas::where('code', '0')->first();
        $jurusan = Jurusan::where('code', '0')->first();
        // Validate the input
        $this->validate([
            'userJurusan.nama' => 'required|string|max:255',
            'userJurusan.email' => 'required|string|email|max:255|unique:users,email',
            'userJurusan.password' => 'required|string|min:8',
            'userJurusan.fakultas_id' => 'required|exists:fakultas,id',
            'userJurusan.jurusan_id' => 'required|exists:jurusans,id',
        ]);

        User::create([
            'name' => $this->userJurusan['nama'],
            'email' => $this->userJurusan['email'],
            'password' => bcrypt($this->userJurusan['password']),
            'role_id' => 3,
            'fakultas_id' => $fakultas->id,
            'jurusan_id' => $jurusan->id,
        ]);

        return redirect()->to('user_jurusan');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->to('user_jurusan');
    }
}
