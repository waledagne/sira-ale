<x-layout>
    <div class="bg-white rounded-lg shadow-md p-8 w-full md:max-w-xl mx-auto mt-12 py-12">
        <h2 class="text-4xl text-center font-bold mb-4">Register</h2>
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <x-inputs.text id="name" name="name" placeholder="Name" />
            <x-inputs.text id="email" name="email" placeholder="Email" />
            <x-inputs.text id="password" name="password" type="password" placeholder="Password" />
            <x-inputs.text id="password_confirmation" name="password_confirmation" type="password"
                placeholder="Confirm Password" />
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 my-3 rounded focus:outline-none">Register</button>
            <p class="mt-4 text-md text-gray-600">Already have an account
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
            </p>
        </form>
    </div>
</x-layout>
