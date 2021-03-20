<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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
     * Get the map associated with the mission.
     *
     * @return Map
     */
    public function Map()
    {
        return $this->hasOne(Map::class);
    }

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
        $this->rover_starting_orientation = Arr::random(['n','w','e','s']);
        $this->status = 'landed';
        $this->save();
    }
}
