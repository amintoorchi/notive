<div class="mx-auto flex w-full max-w-7xl flex-col gap-8 p-4 sm:p-6 lg:p-8 mt-6">

    <header class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div class="space-y-2">
            <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                <flux:icon name="document-text" class="size-4" />
                <span>Workspace</span>
            </div>

            <h1 class="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                یادداشت های من
            </h1>

            <p class="text-sm leading-6 text-zinc-500 dark:text-zinc-400">
                جایی برای ثبت ایده‌ها، فکرها و چیزهایی که نمی‌خواهی فراموش کنی.
            </p>
        </div>
        <flux:button variant="primary" icon="plus" class="shrink-0" wire:navigate href="{{ route('note.editor') }}">
            یادداشت جدید
        </flux:button>
    </header>


    <section class="grid grid-cols-1 gap-3 sm:grid-cols-3">

        <div class="flex items-center gap-4 rounded-lg border border-zinc-200/80 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                <flux:icon name="document-text" class="size-5" />
            </div>

            <div class="min-w-0 space-y-0.5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    همه یادداشت‌ها
                </p>

                <p class="text-xl font-semibold tabular-nums text-zinc-900 dark:text-white">
                    {{auth()->user()->notes()->count()}}
                </p>
            </div>
        </div>

        {{-- Pinned Notes --}}
        <div class="flex items-center gap-4 rounded-lg border border-zinc-200/80 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400">
                <flux:icon name="star" size="xs" />
            </div>

            <div class="min-w-0 space-y-0.5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    سنجاق‌شده
                </p>

                <p class="text-xl font-semibold tabular-nums text-zinc-900 dark:text-white">
                    {{ $this->notes->where('is_pinned', true)->count() }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-lg border border-zinc-200/80 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                <flux:icon name="globe-alt" class="size-5" />
            </div>

            <div class="min-w-0 space-y-0.5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    یادداشت‌های عمومی
                </p>

                <p class="text-xl font-semibold tabular-nums text-zinc-900 dark:text-white">
                    {{ $this->notes->where('is_public', true)->count() }}
                </p>
            </div>
        </div>

    </section>


    {{-- Notes Toolbar --}}
    <section class="flex flex-col gap-4">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            {{-- Section Title --}}
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    مجموعه یادداشت‌ها
                </h2>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    یادداشت‌هایت را مرور کن.
                </p>
            </div>

            <div class="w-full sm:max-w-xs">
                <flux:input
                    placeholder="جستجو میان یادداشت‌ها"
                    icon="magnifying-glass"
                    clearable
                />
            </div>

        </div>


        {{-- Filters --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1">

            <button
                type="button"
                wire:click="$set('filter', 'all')"
                class="inline-flex h-9 shrink-0 items-center gap-2 rounded-lg px-3 text-sm font-medium transition
                {{ $filter === 'all'
                    ? 'bg-accent text-white'
                    : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
            >
                همه
                <span class="opacity-70">{{ $this->allNotes->count() }}</span>
            </button>

            <button
                type="button"
                wire:click="$set('filter', 'pinned')"
                class="inline-flex h-9 shrink-0 items-center gap-2 rounded-lg px-3 text-sm font-medium transition
                {{ $filter === 'pinned'
                    ? 'bg-accent text-white'
                    : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
            >
                سنجاق‌شده
                <span class="opacity-70">{{ $this->allNotes->where('is_pinned', true)->count() }}</span>
            </button>

            <button
                type="button"
                wire:click="$set('filter', 'public')"
                class="inline-flex h-9 shrink-0 items-center gap-2 rounded-lg px-3 text-sm font-medium transition
                {{ $filter === 'public'
                    ? 'bg-accent text-white'
                    : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
            >
                <flux:icon name="globe-alt" class="size-4" />
                عمومی
                <span class="opacity-70">{{ $this->allNotes->where('is_public', true)->count() }}</span>
            </button>

        </div>
    </section>


    @if ($this->notes->isNotEmpty())

        <section>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">

                @foreach ($this->notes as $note)

                <article
                    wire:key="note-{{ $note->id }}"
                    class="group relative flex min-h-56 flex-col overflow-hidden rounded-lg border border-zinc-200/80 bg-white transition duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700"
                >

                    <a
                        href="{{ route('note.editor', ['note' => $note->id]) }}"
                        wire:navigate
                        class="flex flex-1 flex-col"
                    >
                        {{-- Note Content --}}
                        <div class="flex flex-1 flex-col gap-3 p-5">

                            {{-- Metadata --}}
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2">
                                    @if ($note->is_pinned)
                                        <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950/30 dark:text-blue-400">
                                            <flux:icon name="star" variant="solid" class="size-[18px]" />سنجاق شده
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-1.5 text-zinc-400">
                                    <flux:icon
                                        name="{{ $note->is_public ? 'globe-alt' : 'lock-closed' }}"
                                        class="size-4"
                                    />

                                    <span class="text-xs">
                                        {{ $note->is_public ? 'عمومی' : 'خصوصی' }}
                                    </span>
                                </div>
                            </div>

                            <h3 class="line-clamp-2 text-base font-semibold leading-7 text-zinc-900 dark:text-white">
                                {{ $note->title ?: 'بدون عنوان' }}
                            </h3>

                            <p class="line-clamp-5 text-sm leading-7 text-zinc-500 dark:text-zinc-400">
                                {{ $note->body ?: 'این یادداشت هنوز محتوایی ندارد.' }}
                            </p>

                        </div>
                    </a>

                    <footer class="flex items-center justify-between border-t border-zinc-100 px-5 py-3.5 dark:border-zinc-800">

                        <span class="text-xs text-zinc-400">
                            {{ $note->updated_at->diffForHumans() }}
                        </span>

                        <button
                            type="button"
                            wire:click="togglePin('{{ $note->id }}')"
                        >
                            @if ($note->is_pinned)
                                <flux:icon name="star" variant="solid" />
                            @else
                                <flux:icon name="star" />
                            @endif
                        </button>

                    </footer>

                </article>

                @endforeach

            </div>
        </section>

    @else

        <section class="flex flex-col items-center justify-center rounded-lg border border-dashed border-zinc-300 px-6 py-20 text-center dark:border-zinc-700">

            <div class="mb-6 flex size-16 items-center justify-center rounded-lg bg-accent/10 text-accent">
                <flux:icon name="document-text" class="size-8" />
            </div>

            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                صفحه‌ات هنوز خالیه
            </h3>

            <p class="mt-2 max-w-sm text-sm leading-7 text-zinc-500 dark:text-zinc-400">
                اولین یادداشتت رو بساز؛ ایده‌ها، برنامه‌ها و فکرهای روزمره‌ات رو اینجا نگه دار.
            </p>

            <flux:button variant="primary" icon="plus" class="shrink-0 mt-6" wire:navigate href="{{ route('note.editor') }}">
                ساخت اولین یادداشت
            </flux:button>

        </section>

    @endif

</div>
