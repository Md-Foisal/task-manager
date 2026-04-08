<x-layouts.app>
    <section class="max-w-4xl mx-auto py-8 px-4">
        <header class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">My Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">New Task</a>
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
        @if (session('warning'))
            <p class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                {{ session('warning') }}
            </p>
        @endif

        @forelse($tasks as $task)
            <article class="bg-white border dark:bg-gray-800 border-gray-300 rounded-lg shadow-md px-4 py-2 mb-4 transition duration-300 hover:shadow-lg dark:hover:shadow-accent flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white"><a href="{{ route('tasks.show', $task->id) }}" class="hover:underline">{{ $task->title }}</a></h2>

                @if ($task->due_date)
                    <p class="text-gray-600 dark:text-gray-400">{{ $task->due_date->format('F j, Y') }}</p>
                @endif

                @if ($task->is_completed)
                    <p class="text-green-600 dark:text-green-500">Completed</p>
                @else
                    <p class="text-red-600 dark:text-red-500">Not Completed</p>
                @endif

                <div class="flex space-x-2">
                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="{{ $task->is_completed ? 'bg-gray-500 hover:bg-gray-700' : 'bg-green-500 hover:bg-green-700' }} text-white font-bold py-2 px-4 rounded">
                            {{ $task->is_completed ? 'Undo' : 'Complete' }}
                        </button>
                    </form>

                    <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </form>
                </div>

            </article>
        @empty
            <a href="{{ route('tasks.create') }}" class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded">
                <span class="text-2xl">+</span> Add a task
            </a>
        @endforelse

        <div>{{ $tasks->links() }}</div>
    </section>
</x-layouts.app>
