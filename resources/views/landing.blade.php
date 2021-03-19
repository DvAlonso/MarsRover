@extends('layout')

@section('content')

    <div class="card-body d-flex flex-column align-items-center py-1 mb-3">
        <h4 class="mt-0 mb-5">Welcome to Mars Rover mission control!</h4>
        <p>You can start a new mission in a randomly generated environment</p>
        <a class="btn btn-sm btn-dark mb-5" href="{{ route('mission.new') }}">Start a new mission</a>
        <p class="mb-3">Or review an already completed mission</p>
        <div>
            <div class="input-group mb-3">
                <input id="mission_id" type="text" class="form-control form-control form-control-sm" placeholder="Enter mission ID">
                <div class="input-group-append">
                    <button onClick="findMission()" class="btn btn-dark btn-sm" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-danger">
                {{ session('status') }}
            </div>
        @endif
    </div>

@stop

@push('scripts')
    <script>
        function findMission () {
            let id = document.getElementById('mission_id').value
            if(id.length > 0) {
                window.location.href = '/mission/'+id
            }
        }
    </script>
@endpush