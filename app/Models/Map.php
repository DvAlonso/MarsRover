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

    /**
     * Generates a random amount of obstacles (between 150 and 200)
     * and saves them to this map
     *
     * @return void
     */
    public function generateObstacles()
    {
        $amountOfObstacles = rand(150, 200);
        $obstacles = [];

        for($i = 0; $i < $amountOfObstacles; $i++)
        {
            $coords = $this->randomCoords();
            array_push($obstacles, $coords);
        }

        $this->obstacles = $obstacles;
        $this->save();
    }

    /**
     * Gets random coordinates within this map for obstacle generation.
     * Tries to avoid placing obstacles on top of the rover
     *
     * @return void
     */
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

    /**
     * Simulates the rover moving to a target position.
     * Returns an array with the result and the new position
     *
     * @param int $targetX
     * @param int $targetY
     * @return array
     */
    public function canMoveTo($targetX, $targetY)
    {
        // Check if target position is out of bounds
        if($targetX < 0 || $targetX > 99 || $targetY < 0 || $targetY > 99)
        {
            return [
                'couldMove' => false,
                'reason' => 'out_of_bounds',
                'newX' => $targetX,
                'newY' => $targetY
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
                        'reason' => 'obstacle',
                        'newX' => $targetX,
                        'newY' => $targetY
                    ];
                }
            }
        }

        return [
            'couldMove' => true
        ];
    }
}
