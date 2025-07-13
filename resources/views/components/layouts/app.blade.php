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
            <x-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive />
            <x-button label="Users" icon="o-user" link="{{ route('admin.user.index') }}" class="btn-ghost btn-sm" responsive />

            {{-- User --}}
            @if($user = auth()->user())
                <x-dropdown>
                    <x-slot:trigger>
                        <x-avatar title="Robson Tenório"/>
                    </x-slot:trigger>

                    {{-- By default any click closes dropdown --}}
                    <x-menu-item title="Profiles" />

                    <x-menu-separator />

                    {{-- Use `@click.STOP` to stop event propagation --}}
                    <x-menu-item title="Keep open after click" @click.stop="alert('Keep open')" />

                    {{-- Or `wire:click.stop`  --}}
                    <x-menu-item title="Call wire:click" wire:click.stop="delete" />

                    <x-menu-separator />

                    <x-menu-item @click.stop="">
                        <x-checkbox label="Hard mode" hint="Make things harder" />
                    </x-menu-item>

                    <x-menu-item @click.stop="">
                        <x-checkbox label="Transparent checkout" hint="Make things easier" />
                    </x-menu-item>
                </x-dropdown>
{{--                <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />--}}
            @endif
        </x-slot:actions>
    </x-nav>

    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>

        {{-- This is a sidebar that works also as a drawer on small screens --}}
        {{-- Notice the `main-drawer` reference here --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class=" border-r border-base-content/10">

            {{-- Activates the menu item when a route matches the `link` property --}}
            <x-menu activate-by-route>
                <x-menu-item title="Home" icon="o-home" link="###" />
                <x-menu-item title="Messages" icon="o-envelope" link="###" />
                <x-menu-sub title="Settings" icon="o-cog-6-tooth">
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
