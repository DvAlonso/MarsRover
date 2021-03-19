<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'obstacles' => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'key';
    }

    /**
     * Launch a rover into this mission, setting it's
     * starting coordinates and setting the status
     * to landed
     *
     * @param integer $x
     * @param integer $y
     * @return void
     */
    public function launchRover(int $x, int $y)
    {
        $this->rover_starting_x = $x;
        $this->rover_starting_y = $y;
        $this->status = 'landed';
        $this->save();
    }

    public function generateObstacles()
    {
        $amountOfObstacles = rand(50, 100);
        $obstacles = [];

        for($i = 0; $i < $amountOfObstacles; $i++)
        {
            $coords = $this->randomCoords();
            array_push($obstacles, $coords);
        }

        $this->obstacles = $obstacles;
        $this->save();
    }

    private function randomCoords()
    {
        $coords = [
            'x' => rand(0, 99),
            'y' => rand(0, 99)
        ];

        if($coords['x'] === $this->rover_starting_x && $coords['y'] === $this->rover_starting_y)
        {
            $this->randomCoords();
        }
        else {
            return $coords;
        }
        
    }
}
