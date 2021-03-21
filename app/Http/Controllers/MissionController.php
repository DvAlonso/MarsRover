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


    /**
     * Launch a rover into the specified position. Creates a new map
     * associated to this mission and randomly generates the obstacles
     *
     * @param Request $request
     * @return response
     */
    public function launch(Request $request)
    {
        $request->validate([
            'landingX' => 'nullable|integer|between:0,99',
            'landingY' => 'nullable|integer|between:0,99',
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

        // Default values for landing if the user didn't input any
        $landingX = is_null($request->input('landingX')) ? rand(0,99) : $request->input('landingX');
        $landingY = is_null($request->input('landingY')) ? rand(0,99) : $request->input('landingY');

        // Launch the rover into the specified starting position
        $mission->launchRover($landingX, $landingY);

        // Create a map for this mission and generate the obastacles
        $map = $mission->Map()->create();
        $map->generateObstacles();

        // Simulate some delay since we're sending commands into mars...
        sleep(2);

        return response()->json([
            'message' => 'Rover launched successfully',
            'code' => '200'
        ], 200);
    }

    /**
     * Moves rover based on inputted commands
     *
     * @param Request $request
     * @return response
     */
    public function moveRover(Request $request)
    {
        $request->validate([
            'commands' => 'required|regex:/^[rRlLfF]*$/',
            'mission' => 'required|exists:missions,key'
        ]);

        $mission = Mission::where('key', $request->input('mission'))->first();

        // Make sure the rover is ready to receive commands
        if($mission->status !== 'landed')
        {
            return response()->json([
                'message' => 'Rover is not ready for command input',
                'code' => '422'
            ], 422);
        }

        // Save user input
        $mission->commands = $request->input('commands');
        $mission->save();
        
        // Move rover
        $mission->moveRover();

        // Simulate some delay since we're sending commands into mars...
        sleep(2);

        return response()->json([
            'message' => 'Commands sent to rover successfully',
            'code' => '200'
        ], 200);
    }
}
