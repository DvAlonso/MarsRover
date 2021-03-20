<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'obstacles' => 'array',
    ];

    /**
     * Get the mission associated to this map
     *
     * @return Mission
     */
    public function Mission()
    {
        return $this->belongsTo(Mission::class);
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

        if($coords['x'] === $this->Mission->rover_starting_x && $coords['y'] === $this->Mission->rover_starting_y)
        {
            $this->randomCoords();
        }
        else {
            return $coords;
        }
        
    }

    public function canMoveTo($targetX, $targetY)
    {
        // Check if target position is out of bounds
        if($targetX < 0 || $targetX > 99 || $targetY < 0 || $targetY > 99)
        {
            return [
                'couldMove' => false,
                'reason' => 'out_of_bounds'
            ];
        }

        // Check if there is an obstacle at the target position
        foreach($this->obstacles as $obstacle)
        {
            if($obstacle['x'] === $targetX)
            {
                if($obstacle['y'] === $targetY){
                    return [
                        'couldMove' => false,
                        'reason' => 'obstacle'
                    ];
                }
            }
        }

        return [
            'couldMove' => true
        ];
    }
}
