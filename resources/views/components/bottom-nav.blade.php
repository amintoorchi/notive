@persist('bottom-nav')
    <div class="fixed bottom-6 left-1/2 z-10 flex -translate-x-1/2 lg:hidden">
        <div class="liquid-glass flex w-fit items-center gap-2 rounded-full p-1.5">
            <flux:button
                href="{{ route('note.index') }}"
                wire:navigate
                wire:current="!bg-accent/20 !text-accent"
                variant="ghost"
                icon="document-text"
                class="!size-11 !rounded-full !p-0 transition-colors duration-200"
            />

            <flux:button
                href="{{ route('note.editor') }}"
                wire:navigate
                icon="plus"
                class="!size-11 !rounded-full !bg-accent !p-0 !text-accent-foreground hover:!bg-accent/90"
            />

            <flux:button
                href="{{ route('profile.edit') }}"
                wire:navigate
                wire:current="!bg-accent/20 !text-accent"
                variant="subtle"
                icon="cog-6-tooth"
                class="!size-11 !rounded-full !p-0 transition-colors duration-200"
            />
        </div>
    </div>
@endpersist
