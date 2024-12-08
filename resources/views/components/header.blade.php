<header class="bg-blue-900 text-white p-4" x-data="{ open: false }">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="{{ url('/') }}">SiraAle</a>
        </h1>
        <nav class="hidden md:flex items-center space-x-4">
            <x-nav-link url='/' :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link url='/jobs' :active="request()->is('jobs')">All Jobs</x-nav-link>
            @auth
                <x-nav-link url='/bookmarks' :active="request()->is('bookmarks')">Saved Jobs</x-nav-link>
                {{-- <x-nav-link url='/dashboard' :active="request()->is('dashboard')" icon=gauge>Dashboard</x-nav-link> --}}
                <x-button-link url='/jobs/create' icon='edit '>Create Job</x-button-link>
                <x-logout-button />
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}">
                        @if (Auth::user()->avatar)
                            <img src="/storage/{{ Auth::user()->avatar }}" class="w-10 h-10  rounded-full"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <img src="/storage/avatars/default-avatar.png" alt="{{ Auth::user()->name }} Avatar"
                                class="w-10 h-10 rounded-full">
                        @endif
                    </a>
                </div>
            @else
                <x-nav-link url='/login' :active="request()->is('login')">Login</x-nav-link>
                <x-nav-link url='/register' :active="request()->is('register')">Register</x-nav-link>
            @endauth

        </nav>
        <button id="hamburger" class="text-white md:hidden flex items-center" @click = "open = !open"
            x-bind:aria-expanded="open">
            <i class="fa fa-bars text-2xl"></i>
        </button>
    </div>
    <!-- Mobile Menu -->
    <nav x-show="open" @click.away = "open = false" id="mobile-menu"
        class="md:hidden bg-blue-900 text-white mt-5 pb-4 space-y-2">
        <x-nav-link url='/jobs' :active="request()->is('jobs')" :mobile='true'>All Jobs</x-nav-link>
        <x-nav-link url='/bookmarks' :active="request()->is('bookmarks')" :mobile='true'>Saved Jobs</x-nav-link>
        <x-nav-link url='/login' :active="request()->is('login')" :mobile='true'>Login</x-nav-link>
        <x-nav-link url='/register' :active="request()->is('register')" :mobile='true'>Register</x-nav-link>
        <x-nav-link url='/dashboard' :active="request()->is('dashboard')" :mobile='true'>Dashboard</x-nav-link>
        <x-button-link url='/jobs/create' icon='edit' :block='true'>Create Job</x-button-link>
        <x-logout-button />


    </nav>
</header>
