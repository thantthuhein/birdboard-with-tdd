<div class="card mt-3">
     <ul class="text-sm">
          @php
               $activities = $project->activities->reverse()->values();
          @endphp
          
          @forelse ($activities as $activity)
          <li class="{{ $loop->last ? '' : 'mb-1' }} hover:bg-gray-200 cursor-pointer">
               {{ $activity->activityDetails() }}
               <br>
               <span class="text-xs text-gray-500 inline-block">{{ $activity->created_at->diffForHumans() }}</span>
          </li>
          @empty
          No Records yet.
          @endforelse
     </ul>
</div>
