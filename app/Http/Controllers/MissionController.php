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
}
