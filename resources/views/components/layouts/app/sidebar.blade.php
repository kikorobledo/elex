<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800">

        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">

                <flux:navlist.group  class="grid">

                    @can('Lista de usuarios')

                        <flux:navlist.item  icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>

                    @endcan

                    @can('Lista de usuarios')

                        <flux:navlist.item  icon="user-circle" :href="route('usuarios')" :current="request()->routeIs('usuarios')" wire:navigate>{{ __('Usuarios') }}</flux:navlist.item>

                    @endcan

                    <flux:navlist.item  icon="arrows-pointing-out" :href="route('secciones')" :current="request()->routeIs('secciones')" wire:navigate>{{ __('Secciones') }}</flux:navlist.item>

                    @can('Lista de referentes')

                        <flux:navlist.item  icon="users" :href="route('referentes')" :current="request()->routeIs('referentes')" wire:navigate>{{ __('Referentes') }}</flux:navlist.item>

                    @endcan

                    @can('Lista de referidos')

                        <flux:navlist.item  icon="user-group" :href="route('referidos')" :current="request()->routeIs('referidos')" wire:navigate>{{ __('Referidos') }}</flux:navlist.item>

                    @endcan

                    @if(auth()->user()->hasRole('Administrador'))

                        <flux:navlist.group heading="Administrador" expandable>

                                <flux:navlist.item  icon="cog-6-tooth" :href="url('log-viewer')" :current="request()->routeIs('log-viewer')" wire:navigate>{{ __('Logs') }}</flux:navlist.item>

                                @can('Lista de roles')

                                    <flux:navlist.item  icon="square-3-stack-3d" :href="route('roles')" :current="request()->routeIs('roles')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>

                                @endcan

                                @can('Lista de permisos')

                                    <flux:navlist.item  icon="lock-open" :href="route('permisos')" :current="request()->routeIs('permisos')" wire:navigate>{{ __('Permisos') }}</flux:navlist.item>

                                @endcan

                        </flux:navlist.group>

                    @endif

                </flux:navlist.group>

            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">

                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">

                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">

                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">

                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>

                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">

                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>

                                </div>

                            </div>

                        </div>

                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>

                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>

                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf

                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>

                    </form>

                </flux:menu>

            </flux:dropdown>

        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">

            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">

                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>

                    <flux:menu.radio.group>

                        <div class="p-0 text-sm font-normal">

                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">

                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>

                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">

                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>

                                </div>

                            </div>

                        </div>

                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>

                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>

                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf

                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>

                    </form>

                </flux:menu>

            </flux:dropdown>

        </flux:header>

        {{ $slot }}

        @fluxScripts

        <flux:toast />

    </body>

</html>
