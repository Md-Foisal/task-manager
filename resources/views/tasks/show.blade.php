<x-layouts.app>
    <header class="flex items-center justify-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Task Details</h1>
    </header>

    <article class="max-w-4xl mt-6 mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">{{ $task->title }}</h2>
        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $task->description }}</p>
        @if($task->attachment)
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Attachment:
                <a href="{{ asset('storage/' . $task->attachment) }}" class="text-blue-500 hover:underline" target="_blank">
                    View File
                </a>
            </p>
        @endif
        @forelse($task->tags as $tag)
            <span class="text-sm bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-300 px-2 py-1 rounded">{{ ucfirst($tag->name) }}</span>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">No tags assigned.</p>
        @endforelse
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