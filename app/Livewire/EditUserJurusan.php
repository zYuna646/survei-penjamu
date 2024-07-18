<?php

namespace App\Livewire;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Livewire\Component;

class EditUserJurusan extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'User Jurusan';

    public $userJurusan = [];

    public $dataFakultas;
    public $dataJurusan= [];

    protected $rules = [
        'userJurusan.nama' => 'required|string|max:255',
        'userJurusan.fakultas_id' => 'required|exists:fakultas,id',
        'userJurusan.jurusan_id' => 'required|exists:jurusans,id',
        'userJurusan.email' => 'required|email|max:255',
        'userJurusan.password' => 'nullable|min:8|confirmed',
    ];

    public function mount($id)
    {
       $this->userJurusan = User::FindOrFail($id)->toArray();
       $this->dataFakultas = Fakultas::all(); 
       $this->dataJurusan = Jurusan::all();
    }

    public function getJurusanByFakultas()
    {
        $fakultasId = $this->userJurusan['fakultas_id'];
        $this->dataJurusan = Jurusan::where('fakultas_id', $fakultasId)->get();
    }

    public function render()
    {
        return view('livewire.admin.pengguna.jurusan.edit-user-jurusan')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - User Jurusan');
    }

    public function updateUserJurusan()
    {
        $this->validate();

        $user = User::findOrFail($this->userJurusan['id']);
        // dd($this->userJurusan);
        $user->update([
            'name' => $this->userJurusan['nama'],
            'fakultas_id' => $this->userJurusan['fakultas_id'],
            'jurusan_id' => $this->userJurusan['jurusan_id'],
            'email' => $this->userJurusan['email'],
            'password' => isset($this->userJurusan['password']) ? bcrypt($this->userJurusan['password']) : $user->password,
        ]);

        session()->flash('message', 'Data User Jurusan berhasil diupdate.');
        return redirect()->route('user_jurusan');
    }

}
