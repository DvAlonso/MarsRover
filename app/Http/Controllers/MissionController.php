<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class MissionController extends Controller
{
    /**
     * Starts a new mission by creating a new model 
     * and redirecting the user to the report view
     *
     * @return redirect
     */
    public function start()
    {
        $mission = Mission::create([
            'key' => Uuid::uuid1()
        ]);

        return redirect(route('mission.view', ['mission' => $mission]));
    }
    
    /**
     * Shows the mission report view
     *
     * @param Mission $mission
     * @return view
     */
    public function view(Mission $mission)
    {
        return view('mission')->with(['mission' => $mission]);
    }


    public function launch(Request $request)
    {
        $request->validate([
            'landingX' => 'integer|between:0,99',
            'landingY' => 'integer|between:0,99',
            'mission' => 'required|exists:missions,key'
        ]);

        $mission = Mission::where('key', $request->input('mission'))->first();

        if($mission->status !== 'pending_landing')
        {
            return response()->json([
                'message' => 'Rover has already been launched',
                'code' => '422'
            ], 422);
        }

        // Launch the rover into the specified starting position
        $mission->launchRover($request->input('landingX'), $request->input('landingY'));

        
        $map = $mission->Map()->create();
        $map->generateObstacles();
        

        // Simulate some delay
        sleep(2);

        return response()->json([
            'message' => 'Rover launched successfully',
            'code' => '200'
        ], 200);
    }
}
