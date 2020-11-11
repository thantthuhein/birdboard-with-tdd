<div class="card mt-3">
     <ul class="text-sm">
          @php
               $activities = $project->activities->reverse()->values();
          @endphp
          
          @forelse ($activities as $activity)
          <li class="{{ $loop->last ? '' : 'mb-1' }} text-default hover:bg-page cursor-pointer">
               {{ $activity->activityDetails() }}
               <br>
               <span class="text-xs inline-block">{{ $activity->created_at->diffForHumans() }}</span>
          </li>
          @empty
          No Records yet.
          @endforelse
     </ul>
</div>
