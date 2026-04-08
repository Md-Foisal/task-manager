<x-layouts.app>
    <header class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Task Details</h1>
        <a href="{{ route('tasks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-900 py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:hover:bg-gray-900 dark:text-white dark:hover:text-white">
            Back to Tasks
        </a>
    </header>

    <article class="max-w-4xl mt-6 mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">{{ $task->title }}</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $task->description }}</p>
        @if($task->due_date)
            <p class="text-gray-600 dark:text-gray-400">Due Date: {{ $task->due_date->format('F j, Y') }}</p>
        @else
            <p class="text-gray-600 dark:text-gray-400">No due date set.</p>
        @endif

        @if($task->is_completed)
            <p class="text-green-600 dark:text-green-400 mt-4">Status: Completed</p>
        @else
            <p class="text-red-600 dark:text-red-400 mt-4">Status: Incomplete</p>
        @endif
    </article>

</x-layouts.app>
