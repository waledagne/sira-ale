<x-layout>
  <h1>{{$title}}</h1>
  <ul>
    @forelse ($jobs as $job)
    <li>{{$job}}</li>
    @empty
    <p>No jobs found</p>
  </ul>
  @endforelse
</x-layout>
