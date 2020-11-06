@extends('layouts.app')

@section('content')
<header class="flex items-center py-4 mb-3">
   <div class="flex justify-between items-end w-full">
      <p class="text-sm font-normal text-gray-500">
         <a href="{{ route('projects.index') }}">My Projects</a> / {{ $project->title }}
      </p>
      
      <div class="flex items-center">
         @foreach ($project->members as $member)             
            <img src="{{ gravatar_url($member->email) }}?60}}" alt="{{ $member->name }}'s Project'" class="rounded-full w-8 mr-3">
         @endforeach

         <img
            src="https://res.cloudinary.com/dcs3zcs3v/image/upload/v1598252824/profile.jpg"
            alt="{{ $project->owner->name }}'s Project'" 
            class="rounded-full w-8 mr-3">

         <a href="{{ route('projects.edit', $project) }}" class="button hover:bg-blue-light">Edit Project</a>
      </div>
   </div>
</header>

<main>
   <div class="lg:flex -mx-3">
      <div class="lg:w-3/4 px-3">
         <div class="mb-8">
            <h2 class="text-gray-500 font-normal text-lg mb-3">Tasks</h2>
            
            @foreach ($project->tasks as $task)
                <div class="card mb-4">
                   <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST" class="inline">
                     @csrf
                     @method('PATCH')
                     <div class="flex items-center"">
                           <input type="text" value="{{ $task->body }}" name="body" class="outline-none w-full {{ $task->completed ? 'line-through text-gray-500' : '' }}">
                           <input type="checkbox" name="completed" class="form-checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                     </div>
                  </form>
                </div>
            @endforeach
            <div class="card">
               <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                  @csrf
                  <input placeholder="Add New Task" class="w-full outline-none" name="body">
               </form>
            </div>
            
         </div>

         <div>
            <h2 class="text-gray-500 font-normal text-lg mb-3">General Notes</h2>

            <form action="{{ route('projects.update', $project) }}" method="POST">
               @csrf
               @method('PATCH')
               <textarea name="notes" class="card w-full h-24 min-h-full" placeholder="Add Some Notes...">{{ $project->notes ?? '' }}</textarea>

               <button type="submit" class="button">Save</button>
            </form>
         </div>
      </div>
      
      <div class="lg:w-1/4 px-3">
         @include('projects.card')

         @include('projects.activity.card')
      </div>
   </div>
</main>
@endsection
