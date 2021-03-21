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

        #mission-map {
            border-style: outset;
            border-width: 3px;
            border-color: #11AEFA;
        }

        #main-card {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')

    <div class="card-body py-1 px-5 mb-3 d-flex justify-content-start ">
        @livewire('mission', ['mission' => $mission])
    </div>

@stop

@push('scripts')
    <script src="{{ asset('/js/wheelzoomjs/wheelzoom.js') }}"></script>
    <script src="{{ asset('/js/mission.js') }}"></script>
    <script src="{{ asset('/js/mission-control.js') }}"></script>
@endpush