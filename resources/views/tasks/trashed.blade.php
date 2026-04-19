<x-layouts.app>
    <main class="max-w-4xl mx-auto px-4 py-8">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white text-center">Trashed Tasks</h1>
        </header>

        @if(session('success'))
            <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </p>
        @endif
        @if (session('error'))
            <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </p>
        @endif

        @forelse($tasks as $task)
            <article class="bg-white border dark:bg-gray-800 border-gray-300 rounded-lg shadow-md px-4 py-2 mb-4 transition duration-300 hover:shadow-lg dark:hover:shadow-accent flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $task->title }}</h2>

                @if ($task->due_date)
                    <p class="text-gray-600 dark:text-gray-400">{{ $task->due_date->format('F j, Y') }}</p>
                @endif

                @if ($task->is_completed)
                    <p class="text-green-600 dark:text-green-500">Completed</p>
                @else
                    <p class="text-red-600 dark:text-red-500">Not Completed</p>
                @endif
                <div class="flex space-x-2">
                    <form action="{{ route('tasks.restore', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded h-2xl">Restore</button>
                    </form>
                    <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded h-2xl">Delete Permanently</button>
                    </form>
                </div>
            </article>
        @empty
            <p class="text-gray-600 dark:text-gray-400">No trashed tasks found.</p>
        @endforelse

        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    </main>
</x-layouts.app>
