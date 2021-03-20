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
        'commands_output' => 'array',
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

    public function moveRover()
    {
        $commands = str_split($this->commands);
        $orientation = $this->rover_starting_orientation;
        $currentX = $this->rover_starting_x;
        $currentY = $this->rover_starting_y;
        $output = [];

        foreach($commands as $command)
        {
            $targetX = $this->getTargetX($orientation, $command, $currentX);
            $targetY = $this->getTargetY($orientation, $command, $currentY);
            $resultingOrientation = $this->getResultingOrientation($orientation, $command);

            $canMoveTo = $this->Map->canMoveTo($targetX, $targetY);

            $this->updateOutput($canMoveTo, $targetX, $targetY, $resultingOrientation);

            if($canMoveTo['couldMove'])
            {
                $currentX = $targetX;
                $currentY = $targetY;
                $orientation = $resultingOrientation;
            }
            else
            {
                $this->rover_finishing_x = $currentX;
                $this->rover_finishing_y = $currentY;
                $this->rover_finishing_orientation = $orientation;
                $this->status = 'aborted';
                $this->save();
                return;
            }
        }

        $this->rover_finishing_x = $currentX;
        $this->rover_finishing_y = $currentY;
        $this->rover_finishing_orientation = $orientation;
        $this->status = 'completed';
        $this->save();
    }

    private function updateOutput($canMoveTo, $targetX, $targetY, $resultingOrientation)
    {
        $output = is_null($this->commands_output) ? [] : $this->commands_output;
        
        if($canMoveTo['couldMove'])
        {
            $outputToAppend = [
                'couldMove' => true,
                'newX' => $targetX,
                'newY' => $targetY,
                'newOrientation' => $resultingOrientation
            ];            
        }
        else {
            $outputToAppend = $canMoveTo;
        }

        array_push($output, $outputToAppend);

        $this->commands_output = $output;
        $this->save();
    }

    private function getTargetX($orientation, $command, $currentX)
    {
        if($orientation === 'n')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentX + 1;
                case 'L':
                    return $currentX - 1;
                case 'F':
                    return $currentX;
            }
        }
        else if($orientation === 'e')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentX;
                case 'L':
                    return $currentX;
                case 'F':
                    return $currentX + 1;
            }
        }
        else if($orientation === 'w')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentX;
                case 'L':
                    return $currentX;
                case 'F':
                    return $currentX - 1;
            }
        }
        else if($orientation === 's')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentX - 1;
                case 'L':
                    return $currentX + 1;
                case 'F':
                    return $currentX;
            }
        }
    }

    private function getTargetY($orientation, $command, $currentY)
    {
        if($orientation === 'n')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentY;
                case 'L':
                    return $currentY;
                case 'F':
                    return $currentY - 1;
            }
        }
        else if($orientation === 'e')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentY + 1;
                case 'L':
                    return $currentY - 1;
                case 'F':
                    return $currentY;
            }
        }
        else if($orientation === 'w')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentY - 1;
                case 'L':
                    return $currentY + 1;
                case 'F':
                    return $currentY;
            }
        }
        else if($orientation === 's')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return $currentY;
                case 'L':
                    return $currentY;
                case 'F':
                    return $currentY + 1;
            }
        }
    }

    private function getResultingOrientation($orientation, $command)
    {
        if($orientation === 'n')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return 'e';
                case 'L':
                    return 'w';
                case 'F':
                    return 'n';
            }
        }
        else if($orientation === 'e')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return 's';
                case 'L':
                    return 'n';
                case 'F':
                    return 'e';
            }
        }
        else if($orientation === 's')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return 'w';
                case 'L':
                    return 'e';
                case 'F':
                    return 's';
            }
        }
        else if($orientation === 'w')
        {
            switch(strtoupper($command))
            {
                case 'R':
                    return 'n';
                case 'L':
                    return 's';
                case 'F':
                    return 'w';
            }
        }
    }
}
