<x-layout>

    <h2 class="text-3xl text-center mb-4 font-bold border border-gray-300 p-3">
        Bookmarked Jobs
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-3">
        @forelse ($bookmarks as $bookmark)
            <x-job-card :job="$bookmark" />
        @empty
            <p>No bookmarked jobs found</p>
        @endforelse
    </div>
</x-layout>
