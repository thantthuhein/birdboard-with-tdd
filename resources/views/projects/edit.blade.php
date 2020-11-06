@extends('layouts.app')

@section('content')
<div class="mx-auto my-auto mt-auto bg-white max-w-lg rounded-lg shadow-sm">
    <div class="bg-gray-200 rounded-t-lg px-4 py-5">
        <p class="text-md text-center">Edit Project</p>
    </div>

    <div class="mx-auto max-w-sm px-5 py-4">
        <form action="{{ route('projects.update', $project) }}" method="POST">
          @method('PATCH')

          @include('projects._form', [
               'buttonText' => 'Edit'
          ])
        </form>
    </div>
</div>
@endsection