<?php
    use function Livewire\Volt\{state, layout};

    layout('components.layouts.admin');

    $logout = function () {
        logout();

        $this->redirectIntended(default: route('welcome', absolute: false), navigate: true);
    }
?>

<div>
    @guest
        <x-button :link="route('auth.login')">Login</x-button>
    @endguest

    @auth
        <x-button wire:click="logout">Logout</x-button>
    @endauth
</div>
