@extends('layouts.app')

@section('content')
<header class="flex items-center py-4 mb-3">
   <div class="flex justify-between items-end w-full">
      <h2 class="text-md text-gray-500">My Projects</h2>
      
      <a href="{{ route('projects.create') }}" class="button hover:bg-blue-light">New Project</a>
   </div>
</header>

<main class="lg:flex lg:flex-wrap -mx-3">
   @forelse ($projects as $project)
      <div class="lg:w-1/3 pb-6 px-3">
         @include('projects.card')
      </div>
   @empty
      <div>No Projects Yet.</div>
   @endforelse
</main>
@endsection