<x-layout>
    <h2>Create jobs</h2>
    <form action="/jobs" method="post">
        @csrf
        <input type="text" name="title" placeholder="job">
        <input type="text" name="desc" placeholder="description"/>
        <button type="submit" value="Submit">Submit</button>
    </form>
</x-layout>