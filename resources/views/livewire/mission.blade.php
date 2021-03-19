<div class="w-100 d-flex">
    @if($loading)
    <div class="mx-auto">
        {{ $loadingMessage }}
    </div>
    @else
        @if($mission->status == 'pending_landing')
        <form id="preparation-form" class="w-50 mx-auto d-flex flex-column">
            <h5 class="text-center" style="font-weight: 600">Mission preparation</h5>
            <p style="font-size: 14px;" class="text-center">You can start a new mission by setting up the initial position of the rover. Leave
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
            <div class="d-flex flex-column mx-auto">
                <h5 class="text-center" style="font-weight: 600">Rover status: <span class="text-success">Landed</span></h5>
                <p style="font-size: 14px;" class="text-center">
                    Rover was successfully deployed to x: {{ $mission->rover_starting_x }} y: {{ $mission->rover_starting_y }}
                </p>
            </div>
            <div class="d-flex flex-column mx-auto">
                <h5 class="mx-auto" style="font-weight: 600">Map</h5>
                <canvas wire:init="loadMap" class="mx-auto" canvas id="mission-map" width="600px" height="600px"></canvas>
            </div>
        </div>
        {{-- <div class="mx-auto d-flex flex-column w-100">
            <h5 class="mx-auto" style="font-weight: 600">Map</h5>
            <canvas class="mx-auto" canvas id="mission-map" width="600px" height="600px"></canvas>
        </div> --}}
        @endif
    @endif
</div>