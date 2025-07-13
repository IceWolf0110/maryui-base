<?php
    use App\Models\User;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Validation\Rules;
    use function Livewire\Volt\{state, layout, title};

    layout('components.layouts.auth');

    title('Sign Up');

    state([
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => ''
    ]);

    $register = function() {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('admin.dashboard', absolute: false), navigate: true);
    }
?>

<div>
    <x-auth.card
        :action="__('register')"
        :title="__('Tạo tài khoản')"
        :subtitle="__('Điền thông tin bên di để tạo tài khoản')"
    >
        <div class="mb-4">
            <x-input
                wire:model="name"
                :label="__('Tên')"
                placeholder="Tên của bạn"
                clearable="true"
                required="true"
            />
        </div>

        <div class="mb-4">
            <x-input
                wire:model="email"
                :label="__('Địa chỉ email')"
                placeholder="email@example.com"
                clearable="true"
                required="true"
            />
        </div>

        <div class="mb-4">
            <x-password
                :label="__('Mật khẩu')"
                wire:model="password"
                placeholder="Nhập mật khẩu"
                clearable="true"
                required="true"
            />
        </div>

        <div class="mb-4">
            <x-password
                :label="__('Xác nhận mật khẩu')"
                wire:model="password_confirmation"
                placeholder="Nhập lại mật khẩu"
                clearable="true"
                required="true"
            />
        </div>

        <x-button :label="__('Đăng ký')" type="submit" class="w-full btn-soft"/>

        @if (Route::has('auth.login'))
            <div class="mt-4 text-center text-sm">
                Chưa có tài khoản?&#20;
                <a class="text-sm underline" href="{{ route('auth.login') }}" wire:navigate>
                    {{ __('Đăng nhập') }}
                </a>
            </div>
        @endif
    </x-auth.card>
</div>
