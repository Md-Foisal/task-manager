<x-layouts.app>
    <header class="flex items-center justify-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Task</h1>
    </header>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mt-6 mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <fieldset class="border-none w-full mt-6">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
            @error('title')
                <p class="bg-red-100 border border-red-400 text-red-700 dark:text-red-500 px-4 py-3 rounded my-3">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>
        <fieldset class="border-none w-full mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <p class="bg-red-100 border border-red-400 text-red-700 dark:text-red-500 px-4 py-3 rounded my-3">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>
        <fieldset class="border-none w-full mt-6">
            @if ($task->attachment)
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Current Attachment:
                    <a href="{{ asset('storage/' . $task->attachment) }}" class="text-blue-500 hover:underline" target="_blank">
                        View File
                    </a>
                </p>
            @endif
            <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment</label>
            <input type="file" name="attachment" id="attachment" value="{{ old('attachment') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
            @error('attachment')
                <p class="bg-red-100 border border-red-400 text-red-700 dark:text-red-500 px-4 py-3 rounded my-3">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>
        fieldset class="border-none w-full mt-6">
            <legend class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</legend>
            <div class="flex flex-wrap justified-start items-center gap-4 mt-2">
                @forelse ($tags as $tag)
                    <div class="flex column justified-center items-center">
                        <input type="checkbox" name="tags[]" id="{{ $tag->name }}" value="{{ $tag->id }}" @checked($task->tags->contains('id', $tag->id)) class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="{{ $tag->name }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            {{ ucfirst($tag->name) }}
                        </label>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">We are under maintenance. Tags will be available soon.</p>
                @endforelse
            </div>
            @error('tags')
                <p class="bg-red-100 border border-red-400 text-red-700 dark:text-red-500 px-4 py-3 rounded my-3">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>
        <fieldset class="border-none w-full mt-6">
            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 px-3">
            @error('due_date')
                <p class="bg-red-100 border border-red-400 text-red-700 dark:text-red-500 px-4 py-3 rounded my-3">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>

        <button type="submit" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            Update Task
        </button>
    </form>
</x-layouts.app>
