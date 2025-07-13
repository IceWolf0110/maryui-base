<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased">

        {{-- The navbar with `sticky` and `full-width` --}}
        <x-nav sticky full-width>

            <x-slot:brand>
                {{-- Drawer toggle for "main-drawer" --}}
                <label for="main-drawer" class="lg:hidden mr-3">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>

                {{-- Brand --}}
                <x-app-brand>
                    Hello World
                </x-app-brand>
            </x-slot:brand>

            {{-- Right side actions --}}
            <x-slot:actions>
                <x-theme-toggle class="btn btn-circle btn-ghost btn-sm" />
                <x-button label="Users" icon="o-user" link="{{ route('admin.user.index') }}" class="btn-ghost btn-sm" responsive />
            </x-slot:actions>
        </x-nav>

        {{-- The main content with `full-width` --}}
        <x-main with-nav full-width>

            {{-- This is a sidebar that works also as a drawer on small screens --}}
            {{-- Notice the `main-drawer` reference here --}}
            <x-slot:sidebar drawer="main-drawer" collapsible
                            class="border border-base-content/10 bg-white dark:bg-black">



                {{-- Activates the menu item when a route matches the `link` property --}}
                <x-menu activate-by-route>
                    <x-menu-sub title="Users" icon="o-user">
                        <x-menu-item title="Wifi" icon="o-wifi" link="####" />
                        <x-menu-item title="Archives" icon="o-archive-box" link="####" />
                    </x-menu-sub>
                </x-menu>
            </x-slot:sidebar>

            {{-- The `$slot` goes here --}}
            <x-slot:content>
                {{ $slot }}
            </x-slot:content>
        </x-main>

        {{--  TOAST area --}}
        <x-toast />
    </body>
</html>
