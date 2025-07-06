<?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use function Livewire\Volt\{layout, title, mount};

    layout('components.layouts.auth');

    title('Xác thực email');

    mount(fn() => $this->checkVerification());

    $sendVerification = function () {
        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    };

    $checkVerification = function () {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
        }
    };

    $logout = function () {
        logout();
        $this->redirectIntended(default: route('welcome', absolute: false), navigate: true);
    };
?>

<div>
    <x-card
        :title="__('Xác thực email')"
        :subtitle="__('Hãy xác thực email bằng cách ấn vào link chúng tôi đã gửi.')"
        shadow
        class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 shadow-xs"
    >
        <x-slot:figure>
            <img src="https://picsum.photos/500/200" alt="random image"/>
        </x-slot:figure>

        <x-slot:menu>
            {{-- Theme toggle --}}
            <x-theme-toggle/>
        </x-slot:menu>

        @if(session('status') == 'verification-link-sent')
            <div class='font-medium text-sm text-green-600 mb-4'>
                {{ __('Đường link mới đã đc gửi vào tài khoản email bạn dùng để đăng ký.') }}
            </div>
        @endif

        <x-button
            :label="__('Gửi llink ại link xác thực')"
            class="w-full btn-soft"
            wire:click="sendVerification"
        />

        @if (Route::has('auth.register'))
            <div class="mt-4 text-center text-sm">
                <a class="text-sm underline" wire:click="logout">
                    {{ __('Đăng xuất') }}
                </a>
            </div>
        @endif
    </x-card>

    <div wire:poll.60s="checkVerification"></div>
</div>
