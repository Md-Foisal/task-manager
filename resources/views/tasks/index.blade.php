<x-layouts.app>
    <section class="max-w-4xl mx-auto py-8 px-4">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">My Tasks</h1>
        </header>

        <section class="mb-6 flex flex-wrap items-center gap-3">
            <form action="{{ route('tasks.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="filter" value="{{ request('filter') }}">
                <div class="relative">
                    <flux:icon.magnifying-glass
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4" />
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                        class="pl-9 bg-white border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                </div>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Search</button>
            </form>

            <div class="flex items-center gap-2">
                <a href="{{ route('tasks.index') }}"
                    class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-semibold py-2 px-4 rounded-lg">
                    <flux:icon.squares-2x2 class="w-4 h-4" /> All
                </a>
                <a href="{{ route('tasks.index', ['filter' => 'completed', 'search' => request('search')]) }}"
                    class="flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-700 dark:bg-green-800 dark:hover:bg-green-700 dark:text-white font-semibold py-2 px-4 rounded-lg">
                    <flux:icon.check-circle class="w-4 h-4" /> Completed
                </a>
                <a href="{{ route('tasks.index', ['filter' => 'incomplete', 'search' => request('search')]) }}"
                    class="flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-800 dark:hover:bg-red-700 dark:text-white font-semibold py-2 px-4 rounded-lg">
                    <flux:icon.x-circle class="w-4 h-4" /> Incomplete
                </a>
            </div>
        </section>


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
            <article
                class="bg-white border dark:bg-gray-800 border-gray-300 rounded-lg shadow-md px-4 py-2 mb-4 transition duration-300 hover:shadow-lg dark:hover:shadow-accent flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white"><a href="{{ route('tasks.show', $task->id) }}"
                        class="hover:underline">{{ $task->title }}</a></h2>

                @forelse ($task->tags as $tag)
                    <span
                        class="text-sm bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-300 px-2 py-1 rounded">{{ ucfirst($tag->name) }}</span>
                @empty
                    <span class="text-sm text-gray-500 dark:text-gray-400">No tags</span>
                @endforelse

                @if ($task->due_date)
                    <p class="text-gray-600 dark:text-gray-400">{{ $task->due_date->format('F j, Y') }}</p>
                @endif

                @if ($task->is_completed)
                    <p class="text-green-600 dark:text-green-300">Completed</p>
                @else
                    <p class="text-red-600 dark:text-red-300">Not Completed</p>
                @endif

                <div class="flex space-x-2">
                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="{{ $task->is_completed ? 'bg-gray-700 hover:bg-gray-600' : 'bg-green-700 hover:bg-green-600' }} text-white font-bold py-2 px-4 rounded">
                            {{ $task->is_completed ? 'Undo' : 'Complete' }}
                        </button>
                    </form>

                    <a href="{{ route('tasks.edit', $task->id) }}"
                        class="bg-yellow-700 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Edit</a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-700 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete</button>
                    </form>
                </div>

            </article>
        @empty
            <a href="{{ route('tasks.create') }}"
                class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded">
                <span class="text-2xl">+</span> Add a task
            </a>
        @endforelse

        <div>{{ $tasks->appends(request()->query())->links() }}</div>
    </section>
</x-layouts.app>