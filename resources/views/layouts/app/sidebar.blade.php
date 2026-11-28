<!DOCTYPE html>
<html lang="fa" dir="rtl" class="{{ ($_COOKIE['appearance'] ?? '') === 'dark' ? 'dark' : '' }} bg-apple-bg dark:bg-black">

<head>
    @include('partials.head')
</head>

<body class="h-screen overflow-hidden rounded-rasdasdt-2xl bg-zinc-100 dark:bg-zinc-900 ">

    <div class="flex h-screen overflow-hidden">

        <flux:sidebar sticky collapsible class="h-full bg-zinc-100 dark:bg-zinc-900">
            <flux:sidebar.header>
                <flux:sidebar.brand href="{{ route('home') }}" wire:navigate
                    logo="{{ Auth::user()->avatar ?: asset('/images/avatar-placeholder.png') }}"
                    logo:dark="{{ Auth::user()->avatar ?: asset('/images/avatar-placeholder.png') }}"
                    name="{{ Auth::user()->name }}" />
                <flux:sidebar.collapse
                    class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <!--<flux:sidebar.item icon="home" href="{{ route('dashboard') }}" wire:navigate wire:current>داشبورد</flux:sidebar.item>-->
                <flux:sidebar.group expandable icon="document" heading="یادداشت ها" class="grid">
                    <flux:sidebar.item icon="pencil" href="{{ route('note.index') }}" wire:current wire:navigate>یادداشت های من</flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            <flux:sidebar.nav class="gap-2">
                <flux:sidebar.item icon="cog-6-tooth" wire:navigate.hover href="{{ route('profile.edit') }}">
                    تنظیمات
                </flux:sidebar.item>
                <flux:sidebar.item icon="bug-ant" wire:navigate.hover href="#this-feature-is-not-avalable">
                    گزارش مشکل
                </flux:sidebar.item>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:sidebar.item as="button" type="submit" icon="arrow-left-start-on-rectangle" variant="danger" class="w-full">
                        خروج از میزکار
                    </flux:sidebar.item>
                </form>
            </flux:sidebar.nav>
        </flux:sidebar>

        <div class="flex h-full flex-1 flex-col overflow-hidden">

            <flux:header class="shrink-0">
                <flux:sidebar.collapse class="lg:hidden" />
                <flux:spacer />
                @livewire('components.jalali-calendar-modal')
            </flux:header>

            <main class="flex-1 overflow-y-auto rounded-tr-4xl relative bg-apple-bg dark:bg-black">
                {{ $slot }}
            </main>

            <x-bottom-nav />

        </div>

    </div>

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>
