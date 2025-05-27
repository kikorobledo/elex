<x-layouts.auth.simple :title="$title ?? null">

    @if(session('mensaje'))

        <div class="mb-4">

            <p>{{ session('mensaje') }}</p>

        </div>

    @endif

    @if ($errors->any())
        <div class="alert alert-danger text-red-400 text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('setpassword.store') }}" class="flex flex-col gap-6">
        @csrf

        <input autocomplete="new-password" name="password" id="password" type="password" class="p-2 w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-2 h-10 leading-[1.375rem]" required placeholder="Contraseña">

        <input autocomplete="new-password" name="password_confirmation" id="password_confirmation" type="password" class="p-2 w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-2 h-10 leading-[1.375rem]" required placeholder="Contraseña">

        <input type="hidden" name="email" value="{{ $email }}">

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Guardar Contraseña') }}</flux:button>
        </div>

    </form>

</x-layouts.auth.simple>
