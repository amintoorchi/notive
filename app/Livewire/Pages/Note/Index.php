<?php

namespace App\Livewire\Pages\Note;

use App\Models\Note;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Layout('layouts::app')]
#[Title('یادداشت‌های من')]
class Index extends Component
{
    public string $filter = 'all';

    #[Computed]
    public function count()
    {
        return auth()->user()->notes()->count();
    }

    #[Computed]
    public function allNotes()
    {
        return auth()->user()->notes()->latest()->get();
    }

    #[Computed]
    public function notes()
    {
        return match ($this->filter) {
            'pinned' => $this->allNotes->where('is_pinned', true),
            'public' => $this->allNotes->where('is_public', true),
            default => $this->allNotes,
        };
    }

    public function togglePin(string $id): void
    {
        $note = auth()->user()->notes()->findOrFail($id);

        $note->update([
            'is_pinned' => ! $note->is_pinned,
        ]);

        unset($this->allNotes, $this->notes);
    }

    public function togglePublic(string $id): void
    {
        $note = auth()->user()->notes()->findOrFail($id);

        $note->update([
            'is_public' => ! $note->is_public,
        ]);

        unset($this->allNotes, $this->notes);
    }

    public function delete(string $id): void
    {
        auth()->user()->notes()->findOrFail($id)->delete();

        unset($this->allNotes, $this->notes);
    }

    public function render()
    {
        return view('pages.note.index');
    }
}
