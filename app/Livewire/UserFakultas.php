<?php

namespace App\Livewire;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\User;
use Livewire\Component;

class UserFakultas extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'User Fakultas';
    
    public $userFakultas = [
        'nama' => '',
        'email' => '',
        'password' => '',
        'fakultas_id' => '',
    ];

    public $dataUserFakultas = [];

    public $dataFakultas;

    public function mount()
    {
        $this->dataFakultas = Fakultas::all();   
        $this->dataUserFakultas = User::where('role_id', '2')->get();   
    }
    public function render()
    {
        return view('livewire.admin.pengguna.fakultas.user-fakultas')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Pengguna Fakultas');
    }

    public function addUserFakultas()
    {
        $fakultas = Fakultas::where('code', '0')->first();
        $jurusan = Jurusan::where('code', '0')->first();
        // Validate the input
        $this->validate([
            'userFakultas.nama' => 'required|string|max:255',
            'userFakultas.email' => 'required|string|email|max:255|unique:users,email',
            'userFakultas.password' => 'required|string|min:8',
            'userFakultas.fakultas_id' => 'required|exists:fakultas,id',
        ]);

        User::create([
            'name' => $this->userFakultas['nama'],
            'email' => $this->userFakultas['email'],
            'password' => bcrypt($this->userFakultas['password']),
            'role_id' => 2,
            'fakultas_id' => $fakultas->id,
            'jurusan_id' => $jurusan->id,
        ]);

        return redirect()->to('user_fakultas');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->to('user_fakultas');
    }

    
}
