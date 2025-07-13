@props([
    'action' => '',
    'title' => '',
    'subtitle' => '',
])

<x-form wire:submit="{{ $action }}">
    <x-card
        :title="__($title)"
        :subtitle="__($subtitle)"
        shadow
        class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 shadow-xs"
    >
        <x-slot:figure>
            <img src="https://picsum.photos/500/200" alt="random image"/>
        </x-slot:figure>

        <x-slot:menu>
            {{-- Theme toggle --}}
            <x-theme-toggle />
        </x-slot:menu>

        @if(session('status'))
            <div class='font-medium text-sm text-green-600'>
                {{ session('status') }}
            </div>
        @endif

        {!! $slot !!}
    </x-card>
</x-form>
