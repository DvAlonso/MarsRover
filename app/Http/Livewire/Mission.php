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

    /**
     * Default values for this properties
     *
     * @return void
     */
    public function mount()
    {
        $this->loading = false;
        $this->loadingMessage = null;
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.mission');
    }

    /**
     * Show the loading status with specified message
     *
     * @param string $message
     * @return void
     */
    public function loading($message)
    {
        $this->loading = true;
        $this->loadingMessage = $message;
    }

    /**
     * Hides the loading status
     *
     * @return void
     */
    public function loaded()
    {
        $this->loading = false;
        $this->loadingMessage = null;
    }

    /**
     * Instructs the browser to draw the map on it's initial state
     *
     * @return void
     */
    public function loadMap()
    {
        $this->emit('loadMap', [
            'x' => $this->mission->rover_starting_x, 
            'y' => $this->mission->rover_starting_y,
            'obstacles' => $this->mission->Map->obstacles
        ]);
    }

    /**
     * Instructs the browser to draw the map on it's finished state
     *
     * @return void
     */
    public function loadFinishedMap()
    {
        $this->emit('loadFinishedMap', [
            'starting_x' => $this->mission->rover_starting_x,
            'starting_y' => $this->mission->rover_starting_y,
            'x' => $this->mission->rover_finishing_x, 
            'y' => $this->mission->rover_finishing_y,
            'obstacles' => $this->mission->Map->obstacles,
            'output' => $this->mission->commands_output
        ]);
    }

}
