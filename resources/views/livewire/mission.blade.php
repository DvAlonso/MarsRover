<div class="w-100 d-flex">
    @if ($loading)
        <div class="mx-auto">
            {{ $loadingMessage }}
        </div>
    @else
        @if ($mission->status == 'pending_landing')
            <form id="preparation-form" class="w-50 mx-auto d-flex flex-column">
                <h5 class="text-center" style="font-weight: 600">Mission preparation</h5>
                <p style="font-size: 14px;" class="text-center">You can start a new mission by setting up the initial
                    position of the rover. Leave
                    blank for random position. Coordinates must be between 0 (included) and 100 (excluded)</p>
                <div class="d-flex justify-content-center">
                    <input id="landingX" type="number" min="0" max="99" class="col-4 form-control form-control-sm mr-4"
                        placeholder="X">
                    <input id="landingY" type="number" min="0" max="99" class="col-4 form-control form-control-sm"
                        placeholder="Y">
                    <input id="mission_id" hidden value="{{ $mission->key }}">
                </div>
                <div class="mx-auto mt-3">
                    <button type="submit" class="btn btn-dark btn-sm">Position rover</button>
                </div>
            </form>
        @elseif($mission->status == 'landed')
            <div class="d-flex flex-column w-100">
                <div class="d-flex justify-content-start mb-3">
                    <div class="my-auto mr-5" style="position:relative">
                        <span style="position: absolute; top:-17px; left:9px;">N</span>
                        <span style="position: absolute; bottom:-16px; left:10px;">S</span>
                        <span style="position: absolute; bottom: 10px; left:-19px;">W</span>
                        <span style="position: absolute; bottom: 10px; right:-14px;">E</span>
                        <i style="font-size:30px" class="bi bi-compass text-info"></i>
                    </div>
                    <div class="d-flex flex-column my-auto">
                        <h5 style="font-weight: 600">Rover status: <span class="text-success">Landed</span></h5>
                        <div class="d-flex">
                            <div class="my-auto mr-2" style="background: black; width: 10px; height: 10px"></div>
                            <span class="my-auto" style="font-size:14px">Rover was successfully deployed to <span
                                    style="font-weight:600">x: {{ $mission->rover_starting_x }}</span> <span
                                    style="font-weight:600">y: {{ $mission->rover_starting_y }}</span> facing <span
                                    style="font-weight:600">{{ ucfirst($mission->rover_starting_orientation) }}</span></span>
                        </div>
                        <div class="d-flex">
                            <div class="my-auto mr-2" style="background: red; width: 10px; height: 10px"></div>
                            <span class="my-auto" style="font-size:14px">Obstacles found nearby and sent to mission
                                map.</span>
                        </div>
                    </div>
                    <div class="my-auto ml-4 flex-grow-1">
                        <p class="mb-1" style="font-weight: bold; font-size: 14px;">Enter a collection of commands (R F L)</p>
                        <form id="commands-form">
                            <div class="input-group mb-3">
                                <input id="mission_id" hidden value="{{ $mission->key }}">
                                <textarea id="commands" style="resize:none" class="form-control form-control-sm" rows="2"></textarea>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark btn-sm" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <div class="d-flex flex-column mx-auto">
                    <h5 class="mx-auto" style="font-weight: 600">Map</h5>
                    <canvas wire:init="loadMap" class="mx-auto" canvas id="mission-map" width="600px"
                        height="600px"></canvas>
                </div>
            </div>
        @else
            <div class="d-flex w-100">
                <div class="d-flex flex-column mb-3" style="width: 40%">
                    <h5 class="mb-3" style="font-weight:600">Mission report</h5>
                    <p class="mb-1 text-secondary" >Mission result: 
                        @if($mission->status === 'completed')
                            <span class="text-success">Success</span>
                        @else
                            <span class="text-danger">Aborted</span>
                        @endif
                    </p>
                    @if($mission->status === 'aborted')
                    <p class="mb-1 text-secondary">Aborting reason: {{ $mission->aborting_reason }}</p>
                    @endif
                    <p class="mb-1 text-secondary">Last rover position: X={{ $mission->rover_finishing_x }} Y={{ $mission->rover_finishing_y }}</p>
                    <p class="text-secondary">Last rover orientation: {{ $mission->rover_finishing_orientation }}</p>
                    <h5 class="mb-3" style="font-weight:600">Mission Input</h5>
                    <p class="mb-1 text-secondary">Starting rover position: X={{ $mission->rover_starting_x }} Y={{ $mission->rover_starting_y }}</p>
                    <p class="mb-1 text-secondary">Starting rover orientation: {{ $mission->rover_starting_orientation }}</p>
                    <p class="text-secondary" style="width:80%;">Input sent: {{ $mission->commands }}</p>
                    <h5 class="mb-3" style="font-weight:600">Rover Output log</h5>
                    <pre class="mb-4" style="border: 1px solid lightgray; width: 70%; max-height: 300px; overflow-y:scroll" id="output">
                    </pre>
                    <h5 class="" style="font-weight:600">Mission ID</h5>
                    <span style="font-size:14px">{{ $mission->key }}</span>
                    <div>
                        <a class="btn btn-sm btn-dark mt-3" href="{{ route('mission.new') }}">New mission</a>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="mx-auto mb-1" style="font-weight: 600">Map</h5>
                    <span class="mx-auto mb-2" style="font-size:12px">Use mouse to zoom / drag</span>
                    <div id="canvas-wrapper">
                        <canvas wire:init="loadFinishedMap" class="mx-auto" id="mission-map" width="600px"
                        height="600px"></canvas>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
