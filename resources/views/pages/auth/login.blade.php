<x-layouts::auth :title="__('ورود')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ورود به حساب کاربری')" :description="__('آدرس ایمیل و رمز عبور خود را برای ورود وارد کنید')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />


        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('آدرس ایمیل')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('رمز عبور')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('رمز عبور')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('رمز عبور خود را فراموش کرده‌اید؟') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('مرا به خاطر بسپار')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('ورود') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('حساب کاربری ندارید؟') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('ثبت‌نام') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
