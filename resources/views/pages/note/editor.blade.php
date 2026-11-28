<div class="mx-auto w-full max-w-7xl px-5 pb-10 pt-5 sm:px-10 sm:pt-8">

    <header class="flex items-center justify-between gap-3">
        <a
            href="{{ route('note.index') }}"
            wire:navigate
            class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-100"
        >
            <flux:icon.arrow-right class="size-4" />
            <span>یادداشت‌ها</span>
        </a>

        <div class="inline-flex items-center gap-2 rounded-lg bg-zinc-100 px-3 py-2 dark:bg-zinc-800">
            <span class="size-1.5 shrink-0 rounded-full bg-accent"></span>

            <span class="max-w-48 truncate text-xs font-medium text-zinc-600 dark:text-zinc-400">
                @if ($note)
                    {{ Str::limit($note->title, 10, '...') }}
                @else
                    یادداشت جدید
                @endif
            </span>
        </div>
    </header>

    <main class="mx-auto mt-10 w-full max-w-7xl sm:mt-16">

        {{-- Title --}}
        <div class="mb-6">
            <input
                type="text"
                placeholder="عنوان یادداشت"
                wire:model.live.debounce.500ms="title"
                class="w-full border-0 bg-transparent p-0 text-3xl font-bold tracking-tight text-zinc-900 placeholder:text-zinc-300 focus:outline-none focus:ring-0 dark:text-zinc-100 dark:placeholder:text-zinc-700 sm:text-5xl sm:leading-tight"
            />
        </div>

        <textarea
            placeholder="شروع به نوشتن کنید :_)))"
            wire:model.live.debounce.500ms="body"
            class="min-h-[65vh] w-full resize-none border-0 bg-transparent p-0 text-base leading-8 text-zinc-600 placeholder:text-zinc-400 focus:outline-none focus:ring-0 dark:text-zinc-300 dark:placeholder:text-zinc-600 sm:text-lg sm:leading-10"
        ></textarea>

    </main>

    <div class="fixed bottom-24 left-1/2 z-40 -translate-x-1/2">
        <div class="flex items-center gap-1 rounded-2xl border border-white/50 bg-white/70 p-1.5 shadow-lg shadow-black/5 backdrop-blur-2xl backdrop-saturate-150 dark:border-white/10 dark:bg-zinc-900/70">

            <button
                type="button"
                wire:click="togglePin"
                class="flex size-10 items-center justify-center rounded-xl transition
                    {{ $isPinned
                        ? 'bg-accent/10 text-accent'
                        : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-100' }}"
                title="{{ $isPinned ? 'برداشتن سنجاق' : 'سنجاق کردن' }}"
            >
                @if ($isPinned)
                    <flux:icon name="bookmark" variant="solid" class="size-[18px]" />
                @else
                    <flux:icon name="bookmark" class="size-[18px]" />
                @endif
            </button>

            <button
                type="button"
                wire:click="togglePublic"
                class="flex size-10 items-center justify-center rounded-xl transition
                    {{ $isPublic
                        ? 'bg-accent/10 text-accent'
                        : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-zinc-100' }}"
                title="{{ $isPublic ? 'عمومی' : 'خصوصی' }}"
            >
                @if ($isPublic)
                    <flux:icon name="globe-alt" variant="solid" class="size-[18px]" />
                @else
                    <flux:icon name="lock-closed" class="size-[18px]" />
                @endif
            </button>

        </div>
    </div>

</div>
