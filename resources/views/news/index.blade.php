<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-white bg-gradient-to-r from-gray-800 via-gray-700 to-gray-600 rounded-lg p-4 shadow-md">
            {{ __('News') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-900 shadow-lg sm:rounded-lg border border-gray-700 dark:border-gray-600 p-6">
                <h3 class="text-2xl font-semibold mb-4">{{ __('Latest News') }}</h3>
                <p class="mb-4">
                    This is a placeholder for the News section. Here, you can display the latest articles, updates, or announcements.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- First News Item -->
                    <div class="bg-gray-700 rounded-lg p-4 transition hover:bg-gray-600 cursor-pointer" onclick="window.open('https://www.metalsucks.net/?s=stoner', '_blank')">
                        <h4 class="text-lg font-bold text-white">MetalSucks - Stoner</h4>
                        <p class="text-gray-300">Click here for the latest stoner news from MetalSucks.</p>
                    </div>

                    <!-- Second News Item -->
                    <div class="bg-gray-700 rounded-lg p-4 transition hover:bg-gray-600 cursor-pointer" onclick="window.open('https://blabbermouth.net/search?query=stoner', '_blank')">
                        <h4 class="text-lg font-bold text-white">Blabbermouth - Stoner</h4>
                        <p class="text-gray-300">Click here for the latest stoner updates from Blabbermouth.</p>
                    </div>

                    <!-- Add more news items as needed -->
                </div>

                <p class="mt-4">
                    Stay tuned for more updates as we continue to enhance this section.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
