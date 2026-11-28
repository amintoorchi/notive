<x-layouts::auth :title="__('ثبت‌نام')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ایجاد حساب کاربری')" :description="__('برای ایجاد حساب کاربری، اطلاعات خود را وارد کنید')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('نام')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('نام و نام خانوادگی')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('آدرس ایمیل')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('رمز عبور')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('رمز عبور')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('تکرار رمز عبور')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('تکرار رمز عبور')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('ایجاد حساب کاربری') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('قبلاً حساب کاربری ایجاد کرده‌اید؟') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('ورود') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
