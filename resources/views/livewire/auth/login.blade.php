<?php
    use Illuminate\Auth\Events\Lockout;
    use Illuminate\Validation\ValidationException;
    use function Livewire\Volt\{state, layout, title};

    title('Login');

    layout('components.layouts.auth');

    state([
        'email' => '',
        'password' => '',
        'remember' => false
    ]);

    $login = function () {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];

        $this->validate($rules);

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    };

    $ensureIsNotRateLimited = function () {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    };

    $throttleKey = function () {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
?>

<div>
    <x-auth.card
        :action="__('login')"
        :title="__('Đăng nhập vào tài khoản của bạn')"
        :subtitle="__('Nhập tài khoản và mật khẩu để đăng nhập')"
    >
        <div class="mb-4">
            <x-input
                wire:model="email"
                :label="__('Địa chỉ email')"
                placeholder="email@example.com"
                clearable="true"
                required="true"
                class="bg-white dark:bg-black"
            />
        </div>

        <div class="mb-4">
            <x-password
                :label="__('Mật khẩu')"
                wire:model="password"
                placeholder="Nhập mật khẩu"
                clearable="true"
                required="true"
                class="bg-white dark:bg-black"
            />
        </div>

        <div class="flex justify-between items-center text-center mb-4">
            <x-checkbox label="Remember me" wire:model="remember" />
            @if (Route::has('auth.password.request'))
                <a class="text-sm underline" href="{{ route('auth.password.request') }}" wire:navigate>
                    {{ __('Quên mật khẩu') }}
                </a>
            @endif
        </div>

        <x-button :label="__('Đăng nhập')" type="submit" class="w-full btn-soft"/>

        @if (Route::has('auth.register'))
            <div class="mt-4 text-center text-sm">
                Chưa có tài khoản?&#20;
                <a class="text-sm underline" href="{{ route('auth.register') }}" wire:navigate>
                    {{ __('Đăng ký') }}
                </a>
            </div>
        @endif
    </x-auth.card>
</div>
