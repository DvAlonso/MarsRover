<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Mission extends Component
{
    /**
     * The mission this component is bound to
     *
     * @var \App\Models\Mission
     */
    public $mission;
    public $loading;
    public $loadingMessage;

    protected $listeners = ['loading' => 'loading', 'loaded' => 'loaded'];

    public function mount()
    {
        $this->loading = false;
        $this->loadingMessage = null;
    }

    public function render()
    {
        return view('livewire.mission');
    }

    public function loading($message)
    {
        $this->loading = true;
        $this->loadingMessage = $message;
    }

    public function loaded()
    {
        $this->loading = false;
        $this->loadingMessage = null;
    }

    public function loadMap()
    {
        $this->emit('loadMap', [
            'x' => $this->mission->rover_starting_x, 
            'y' => $this->mission->rover_starting_y,
            'obstacles' => $this->mission->Map->obstacles
        ]);
    }

}
