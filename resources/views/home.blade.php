@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-2xl my-2">{{ __('Dashboard') }}</div>

            <div class="rounded h-20 flex items-center text-5xl bg-white text-red-500">
                <a href="{{ route('projects.index') }}">See Projects</a>
            </div>
        </div>
    </div>
</div>
@endsection
