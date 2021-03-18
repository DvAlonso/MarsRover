@extends('layout')

@section('content')

    <div class="card-body d-flex flex-column align-items-center py-1 mb-3">
        <h4 class="mt-0 mb-5">Welcome to Mars Rover mission control!</h4>
        <p>You can start a new mission in a randomly generated environment</p>
        <a class="btn btn-sm btn-dark mb-5" href="{{ route('mission') }}">Start a new mission</a>
        <p class="mb-3">Or review an already completed mission</p>
        <form method="POST">
            <div class="input-group mb-3">
                <input name="id" type="text" class="form-control form-control form-control-sm" placeholder="Enter mission ID">
                <div class="input-group-append">
                    <button class="btn btn-dark btn-sm" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

@stop
