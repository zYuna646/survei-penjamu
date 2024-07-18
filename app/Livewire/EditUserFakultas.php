<?php

namespace App\Livewire;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Livewire\Component;

class EditUserFakultas extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'User Fakultas';

    public $userFakultas = [];

    public $dataFakultas;

    protected $rules = [
        'userFakultas.nama' => 'required|string|max:255',
        'userFakultas.fakultas_id' => 'required|exists:fakultas,id',
        'userFakultas.jurusan_id' => 'required|exists:jurusans,id',
        'userFakultas.email' => 'required|email|max:255',
        'userFakultas.password' => 'nullable|min:8|confirmed',
    ];

    public function mount($id)
    {
       $this->userFakultas = User::FindOrFail($id)->toArray();
       $this->dataFakultas = Fakultas::all(); 
    }
    public function render()
    {
        return view('livewire.admin.pengguna.fakultas.edit-user-fakultas')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - User Fakultas');
    }

    public function updateUserFakultas()
    {
        $this->validate();

        $user = User::findOrFail($this->userFakultas['id']);
        // dd($this->userFakultas);
        $user->update([
            'name' => $this->userFakultas['nama'],
            'fakultas_id' => $this->userFakultas['fakultas_id'],
            'email' => $this->userFakultas['email'],
            'password' => isset($this->userFakultas['password']) ? bcrypt($this->userFakultas['password']) : $user->password,
        ]);

        session()->flash('message', 'Data User Jurusan berhasil diupdate.');
        return redirect()->route('user_fakultas');
    }
}
