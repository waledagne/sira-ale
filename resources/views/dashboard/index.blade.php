<x-layout>
    <section class="flex flex-col gap-4 md:flex-row">
        <div class="bg-white p-8 rounded-lg shadow-md w-full">

            <h3 class="text-3xl text-center font-bold mb-4">
                Profile Information
            </h3>
            @if ($user->avatar)
                <div class="mt-2 justify-center">
                    <img src="/storage/{{ $user->avatar }}" alt="{{ $user->name }} Avatar"
                        class="w-32 h-32 rounded-full mx-auto object-cover">
                </div>
            @endif
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-inputs.text id="name" name="name" label="Name" placeholder='John Doe'
                    value="{{ $user->name }}" />
                <x-inputs.text id="email" name="email" label="Email" placeholder='H6Ko3@example.com'
                    value="{{ $user->email }}" />

                <x-inputs.file id="avatar" name="avatar" label="Upload Avatar" />
                <button type="submit"
                    class="w-full bg-green-500 text-white px-4 py-2 border rounded focus:outline-none">Save</button>

            </form>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-md w-full">
            <h3 class="text-3xl text-center font-bold mb-4">
                My Job Listings
            </h3>
            @forelse($jobs as $job)
                <div class="flex justify-between items-center py-2">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $job->title }}</h3>
                        <p class="text-gray-700">{{ $job->job_type }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('jobs.edit', $job->id) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded text-sm">Edit</a>
                        <form method="POST" action="{{ route('jobs.destroy', $job->id) }}?from=dashboard"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-700">No job listings found</p>
            @endforelse
        </div>
    </section>
    <x-bottom-banner />
</x-layout>
