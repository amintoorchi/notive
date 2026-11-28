<?php

use App\Concerns\PasswordValidationRules;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\On;

new #[Title('تنظیمات امنیت')] class extends Component {
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $canManageTwoFactor;

    public bool $twoFactorEnabled;

    public bool $requiresConfirmation;


    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }

    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(variant: 'success', text: __('رمز عبور با موفقیت به‌روزرسانی شد.'));
    }


    /**
     * Handle the two-factor authentication enabled event.
     */
    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
}; ?>

<section class="w-full !py-10 !px-4">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('تنظیمات امنیت') }}</flux:heading>

    <x-pages::settings.layout  :heading="__('تغییر رمز عبور')" :subheading="__('برای حفظ امنیت حساب خود، از یک رمز عبور طولانی و تصادفی استفاده کنید')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('رمز عبور فعلی')"
                type="password"
                required
                autocomplete="current-password"
                viewable
            />
            <flux:input
                wire:model="password"
                :label="__('رمز عبور جدید')"
                type="password"
                required
                autocomplete="new-password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('تکرار رمز عبور جدید')"
                type="password"
                required
                autocomplete="new-password"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" data-test="update-password-button">
                    {{ __('ذخیره') }}
                </flux:button>
            </div>
        </form>

        @if ($canManageTwoFactor)
            <section class="mt-12">
                <flux:heading>{{ __('احراز هویت دو مرحله‌ای') }}</flux:heading>
                <flux:subheading>{{ __('تنظیمات احراز هویت دو مرحله‌ای خود را مدیریت کنید') }}</flux:subheading>

                <div class="flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                    @if ($twoFactorEnabled)
                        <div class="space-y-4">
                            <flux:text>
                                {{ __('هنگام ورود، از شما خواسته می‌شود کد امنیتی یک‌بارمصرفی را وارد کنید که می‌توانید آن را از برنامه احراز هویت نصب‌شده روی گوشی خود دریافت کنید.') }}
                            </flux:text>

                            <div class="flex justify-start">
                                <flux:button
                                    variant="danger"
                                    wire:click="disable"
                                >
                                    {{ __('غیرفعال‌سازی احراز هویت دو مرحله‌ای') }}
                                </flux:button>
                            </div>

                            <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                        </div>
                    @else
                        <div class="space-y-4">
                            <flux:text variant="subtle">
                                {{ __('با فعال‌سازی احراز هویت دو مرحله‌ای، هنگام ورود از شما خواسته می‌شود کد امنیتی یک‌بارمصرفی را وارد کنید. این کد از طریق برنامه‌های احراز هویت سازگار با TOTP روی گوشی شما قابل دریافت است.') }}
                            </flux:text>

                            <flux:modal.trigger name="two-factor-setup-modal">
                                <flux:button
                                    variant="primary"
                                    wire:click="$dispatch('start-two-factor-setup')"
                                >
                                    {{ __('فعال‌سازی احراز هویت دو مرحله‌ای') }}
                                </flux:button>
                            </flux:modal.trigger>

                            <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                        </div>
                    @endif
                </div>
            </section>
        @endif

    </x-pages::settings.layout>

</section>
