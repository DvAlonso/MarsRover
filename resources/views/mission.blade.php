@extends('layout')

@push('styles')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('content')

    <div class="card-body py-1 px-5 mb-3 d-flex justify-content-start ">
        <div class="d-flex flex-column pr-4">
            <h5 class="text-center" style="font-weight: 600">Mission preparation</h5>
            <p style="font-size: 14px;">You can start a new mission by setting up the initial position of the rover. Leave blank for random position. Coordinates must be between 0 (included) and 100 (excluded)</p>
            <div class="d-flex justify-content-center">
                <input id="rover-x" type="number" min="0" max="99" class="col-4 form-control form-control-sm mr-4" placeholder="X">
                <input id="rover-y" type="number" min="0" max="99" class="col-4 form-control form-control-sm" placeholder="Y">
            </div>
            <div class="mx-auto mt-3">
                <button onClick="drawRover()" class="btn btn-dark btn-sm">Position rover</button>
            </div>
        </div>
        <div class="ml-auto">
            <h5 class="text-center" style="font-weight: 600">Map</h5>
            <canvas canvas id="mission-map" width="600px" height="600px"></canvas>
        </div>
    </div>

@stop

@push('scripts')
    <script src="{{ asset('/js/mission.js') }}"></script>
@endpush