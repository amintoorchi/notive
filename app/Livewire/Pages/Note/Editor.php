<?php

namespace App\Livewire\Pages\Note;

use App\Models\Note;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;

#[Layout('layouts::app')]
#[Title('ادیتور')]
class Editor extends Component
{
    #[Locked]
    public ?Note $note = null;

    public string $title = '';

    public string $body = '';

    public bool $isPinned = false;

    public bool $isPublic = false;

    public function mount(?Note $note = null): void
    {
        if ($note) {
            $this->note = auth()->user()
                ->notes()
                ->findOrFail($note->id);

            $this->title = $this->note->title;
            $this->body = $this->note->body ?? '';
            $this->isPinned = $this->note->is_pinned;
            $this->isPublic = $this->note->is_public;
        }
    }

    public function togglePin(): void
    {
        $this->isPinned = ! $this->isPinned;

        $this->note?->update([
            'is_pinned' => $this->isPinned,
        ]);
    }

    public function togglePublic(): void
    {
        $this->isPublic = ! $this->isPublic;

        $this->note?->update([
            'is_public' => $this->isPublic,
        ]);
    }

    public function updatedTitle(): void
    {
        $this->save();
    }

    public function updatedBody(): void
    {
        $this->save();
    }

    public function save(): void
    {
        if (blank($this->title) && blank($this->body)) {
            return;
        }

        $data = [
            'title' => blank($this->title) ? 'Untitled' : $this->title,
            'body' => $this->body,
            'is_pinned' => $this->isPinned,
            'is_public' => $this->isPublic,
        ];

        if ($this->note) {
            $this->note->update($data);
        } else {
            $this->note = auth()->user()->notes()->create($data);
        }
    }

    public function render()
    {
        return view('pages.note.editor');
    }
}
