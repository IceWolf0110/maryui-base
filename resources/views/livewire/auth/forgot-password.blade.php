<?php
    use Illuminate\Support\Facades\Password;
    use function Livewire\Volt\{state, layout, title};

    state([
        'email' => ''
    ]);

    title('Forgot Password');

    layout('components.layouts.auth');

    $sendPasswordResetLink = function () {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
?>

<div>
    <x-auth.card
        :action="__('sendPasswordResetLink')"
        :title="__('Quên mật khẩu')"
        :subtitle="__('Nhập email để gửi link thay đổi mật khẩu')"
    >
        <div class="mb-6">
            <x-input
                wire:model="email"
                :label="__('Địa chỉ email')"
                placeholder="email@example.com"
                clearable="true"
                required="true"
                class="bg-white dark:bg-black"
            />
        </div>

        <x-button :label="__('Email đường dẫn thay đổi mật khẩu')" type="submit" class="w-full btn-soft"/>

        <div class="mt-4 text-center text-sm">
            {{ __('Trở về trang') }}
            <a class="underline" href="{{ route('auth.login') }}" wire:navigate>Đăng nhập</a>
        </div>
    </x-auth.card>
</div>
