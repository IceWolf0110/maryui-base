<?php

    use App\Models\User;
    use Mary\Traits\Toast;
    use Illuminate\Support\Collection;
    use function Livewire\Volt\{state, with, uses, layout};

    layout('components.layouts.admin');

    uses([
        Toast::class
    ]);

    const STATE = [
        'search' => '',
        'drawer' => false,
        'sortBy' => [
            'column' => 'name',
            'direction' => 'asc'
        ]
    ];

    state(STATE);

    $users = fn(): Collection => User::all()
        ->sortBy([[...array_values($this->sortBy)]])
        ->when($this->search, function (Collection $collection) {
            return $collection->filter(fn(array $item) => str($item['name'])->contains($this->search, true));
        });

    $headers = fn(): array => [
        ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'w-64'],
        ['key' => 'email', 'label' => 'E-mail', 'sortable' => false],
    ];

    $delete = function ($id): void {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    };

    $clear = function () {
        $this->reset();

        $this->search = STATE['search'];
        $this->drawer = STATE['drawer'];
        $this->sortBy = STATE['sortBy'];

        $this->success('Filters cleared.', position: 'toast-bottom');
    };

    with(fn() => [
        'users' => $this->users(),
        'headers' => $this->headers(),
    ]);
?>

<div>
    <!-- HEADER -->
    <x-header title="Hello" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card shadow>
        <x-table
            :headers="$headers"
            :rows="$users"
            :sort-by="$sortBy"
        >
            @scope('actions', $user)
                <div class="flex">
                    <x-button
                        icon="o-adjustments-horizontal"
                        :link="route('admin.user.user', [
                            'id' => $user->id
                        ])"
                        spinner
                        class="btn-ghost btn-circle btn-sm"
                    />

                    <x-button
                        icon="o-trash"
                        wire:click="delete({{ $user['id'] }})"
                        wire:confirm="Are you sure?"
                        spinner
                        class="btn-ghost btn-circle btn-sm text-error"
                    />
                </div>
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3 ">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
