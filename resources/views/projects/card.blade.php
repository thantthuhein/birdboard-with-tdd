<div class="card p-1" style="height: 200px;">
     <h3 class="font-normal text-2xl py-4 border-l-4 border-blue-light mb-4 -ml-5 pl-4">
     <a href="{{ $project->path() }}" class="text-black no-underline">{{ $project->title }}</a>
     </h3>

     <div class="text-gray-500 mb-5">{{ Str::limit($project->description, 50) }}</div>

     <footer>
          <form action="{{ route('projects.destroy', $project) }}" method="POST" class="text-right text-red-600">
               @method('DELETE')
               @csrf
               <button type="submit" class="text-xs" style="outline: none;">Delete</button>
          </form>
     </footer>
</div>