<?php

namespace App\Livewire;

use Livewire\Component;

class RunSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    public $survey = [
      'name' => 'Survei kepuasan tenaga pendidik',
      'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras lacinia eros blandit lectus rhoncus, . ',
      'target' => 'Universitas',
      'type' => 'Reguler',
      'aspek_total' => 3,
      'aspects' => [
          [
              'name' => 'Aspek Pemersatu Bangsa',
              'indicators' => [
                  'Kemudahan dalam mendapatkan informasi dalam menunjang kegiatan sesuai dengan uraian jabatan serta tugas pokok dan fungsi. (Aspek Tangibles)',
                  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, voluptatem id. Aut placeat cumque voluptas blanditiis, perferendis ad.'
              ]
          ],
          [
              'name' => 'Aspek Kewarganegaraan',
              'indicators' => [
                  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur sapiente debitis impedit, laboriosam porro molestiae provident.',
              ]
          ]
      ]
  ];

    public $nama;
    public $nim;
    public $prodi;
    public $responses = [];
    
    public function render()
    {
        return view('livewire.landing.run-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Survei '.$this->survey['name']);
    }

    public function sendSurveiRespon(){
        dd([
          'nama' => $this->nama,
          'nim' => $this->nim,
          'prodi' => $this->prodi,
          'responses' => $this->responses,
        ]);
    }

}
