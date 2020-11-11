<div class="card flex flex-col">
     <h3 class="font-normal text-2xl py-4 border-l-4 border-blue-light mb-4 -ml-5 pl-4">
     <a href="{{ $project->path() }}" class="text-default no-underline">{{ $project->title }}</a>
     </h3>

     <div class="flex">
          <div class="text-default mb-5 flex-1">{{ $project->description }}</div>
          {{-- <div class="text-gray-500 mb-5 flex-1">{{ Str::limit($project->description, 50) }}</div> --}}
     
          @can('manage', $project)     
               <footer>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="text-right text-red-600">
                         @method('DELETE')
                         @csrf
                         <button type="submit" class="text-xs text-red-500" style="outline: none;">Delete</button>
                    </form>
               </footer>
          @endcan
     </div>
</div>