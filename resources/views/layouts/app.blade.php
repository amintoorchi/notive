<x-layouts::app.sidebar class="rounded-tr-2xl" :title="$title ?? null">
    <flux:main class="rounded-tr-2xl bg-white dark:bg-zinc-950 !p-0 !pb-30 lg:!pb-0">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
