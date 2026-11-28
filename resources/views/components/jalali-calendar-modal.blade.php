<div>
    <flux:modal.trigger name="calendar">
        <flux:button variant="outline" icon="calendar-days">
            تقویم
        </flux:button>
    </flux:modal.trigger>

    <flux:modal :closable="false" name="calendar" class="md:w-[420px]" dir="rtl">
        <div class="space-y-6">

            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <flux:heading size="lg">
                        تقویم شمسی
                    </flux:heading>

                    <p class="text-sm text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)]">
                        امروز
                        <span class="font-medium text-[var(--color-zinc-800)] dark:text-[var(--color-zinc-200)]">
                            {{ strtr($today->format('Y/m/d'), [
                                '0' => '۰', '1' => '۱', '2' => '۲',
                                '3' => '۳', '4' => '۴', '5' => '۵',
                                '6' => '۶', '7' => '۷', '8' => '۸',
                                '9' => '۹',
                            ]) }}
                        </span>
                    </p>
                </div>
                <div class="flex size-10 items-center justify-center rounded-xl bg-[var(--color-accent)]/10 text-[var(--color-accent)]">
                    <flux:modal.close>
                        <flux:button
                            variant="ghost"
                            icon="x-mark"
                            aria-label="بستن تقویم"
                            class="rounded-xl"
                        />
                    </flux:modal.close>
                </div>
            </div>

            <flux:separator variant="subtle" />

            {{-- Month Navigation --}}
            <div class="flex items-center justify-between">
                <flux:button
                    variant="ghost"
                    size="sm"
                    icon="chevron-right"
                    wire:click="previousMonth"
                    class="!size-9 !rounded-xl hover:!bg-[var(--color-accent)]/10 hover:!text-[var(--color-accent)]"
                />

                <div class="text-center">
                    <h3 class="font-semibold text-[var(--color-zinc-900)] dark:text-[var(--color-white)]">
                        {{ $monthName }}
                        {{ strtr((string) $year, [
                            '0' => '۰', '1' => '۱', '2' => '۲',
                            '3' => '۳', '4' => '۴', '5' => '۵',
                            '6' => '۶', '7' => '۷', '8' => '۸',
                            '9' => '۹',
                        ]) }}
                    </h3>
                    <p class="mt-0.5 text-xs text-[var(--color-zinc-400)]">
                        ماه شمسی
                    </p>
                </div>

                <flux:button
                    variant="ghost"
                    size="sm"
                    icon="chevron-left"
                    wire:click="nextMonth"
                    class="!size-9 !rounded-xl hover:!bg-[var(--color-accent)]/10 hover:!text-[var(--color-accent)]"
                />
            </div>

            {{-- Calendar --}}
            <div class="rounded-2xl border border-[var(--color-zinc-200)]/80 bg-[var(--color-zinc-50)]/70 p-3 dark:border-[var(--color-zinc-800)] dark:bg-[var(--color-zinc-900)]/50">
                <div class="grid grid-cols-7 gap-1 text-center">

                    {{-- Weekdays --}}
                    @foreach (['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'] as $dayName)
                        <div class="py-2.5 text-xs font-semibold text-[var(--color-zinc-400)] dark:text-[var(--color-zinc-500)]">
                            {{ $dayName }}
                        </div>
                    @endforeach

                    {{-- Days --}}
                    @foreach ($calendarDays as $day)
                        @if ($day === null)
                            <div class="aspect-square"></div>
                        @else
                            @php
                                $isToday =
                                    $today->getYear() === $year &&
                                    $today->getMonth() === $month &&
                                    $today->getDay() === $day;
                            @endphp

                            <div @class([
                                'flex aspect-square items-center justify-center rounded-xl text-sm transition-colors',
                                'bg-[var(--color-accent)] font-semibold text-[var(--color-accent-foreground)] shadow-sm' => $isToday,
                                'text-[var(--color-zinc-700)] hover:bg-[var(--color-accent)]/10 hover:text-[var(--color-accent)] dark:text-[var(--color-zinc-300)] dark:hover:bg-[var(--color-accent)]/10 dark:hover:text-[var(--color-accent-content)]' => !$isToday,
                            ])>
                                {{ strtr((string) $day, [
                                    '0' => '۰', '1' => '۱', '2' => '۲',
                                    '3' => '۳', '4' => '۴', '5' => '۵',
                                    '6' => '۶', '7' => '۷', '8' => '۸',
                                    '9' => '۹',
                                ]) }}
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-[var(--color-zinc-500)] dark:text-[var(--color-zinc-400)]">
                    <span class="size-2 rounded-full bg-[var(--color-accent)]"></span>
                    امروز
                </div>

                <span class="text-xs text-[var(--color-zinc-400)] dark:text-[var(--color-zinc-500)]">
                    تقویم هجری شمسی
                </span>
            </div>

        </div>
    </flux:modal>
</div>
