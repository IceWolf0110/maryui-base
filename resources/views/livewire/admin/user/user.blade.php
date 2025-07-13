<?php
    use App\Models\User;
    use function Livewire\Volt\{state, with, layout};

    layout('components.layouts.admin');

    with(fn() => [
        'users' => User::all()
    ]);
?>

<div>
    @foreach($users as $user)
        <div>{{ $user->name }}</div>
    @endforeach
</div>
