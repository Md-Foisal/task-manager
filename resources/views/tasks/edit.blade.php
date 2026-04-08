<x-layouts.app>
    <header class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Task</h1>
        <a href="{{ route('tasks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-900 py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:hover:bg-gray-900 dark:text-white dark:hover:text-white">
            Back to Tasks
        </a>
    </header>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="max-w-4xl mt-6 mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
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
