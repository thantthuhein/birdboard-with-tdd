@csrf
<div class="mb-4">
     <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
     <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
     type="text" name="title" id="title" value="{{ $project->title ?? '' }}" required>
</div>

<div class="mb-4">
     <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
     <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
     type="textarea" name="description" id="description" required>{{ $project->description ?? '' }}</textarea>
</div>

<div class="mb-4">
     <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
     <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
     type="textarea" name="notes" id="notes" required>{{ $project->notes ?? '' }}</textarea>
</div>

<div>
     <button type="submit" class="inline-block px-6 py-1 mr-3 bg-blue rounded-lg hover:bg-blue-light focus:outline-none focus:shadow-outline text-white">{{ $buttonText }}</button>
     <a href="{{ $project->path() }}">Cancel</a>
</div>