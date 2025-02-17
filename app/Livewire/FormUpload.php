<?php

namespace App\Livewire;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormUpload extends Component
{
    use WithFileUploads;

    public string $name;

    public array $files = [];

    public $backup = [];

    public function updatingFiles(): void
    {
        $this->backup = $this->files;
    }

    public function updatedFiles(): void
    {
        if (! $this->files) {
            return;
        }
        $file = Arr::flatten(array_merge($this->backup, [$this->files]));
        $this->files = collect($file)->unique(fn (UploadedFile $item) => $item->getClientOriginalName())->toArray();
    }

    public function deleteUpload(array $content): void
    {
        if (! $this->files) {
            return;
        }

        $files = Arr::wrap($this->files);
        /** @var UploadedFile $file */
        $file = collect($files)->filter(fn (UploadedFile $item) => $item->getFilename() === $content['temporary_name'])->first();
        rescue(fn () => $file->delete(), report: false);

        $collect = collect($files)->filter(fn (UploadedFile $item) => $item->getFilename() !== $content['temporary_name']);
        $this->files = $collect->toArray();
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'files' => 'required|array',
            'files.*' => 'required|file|max:1024',
        ];
    }

    public function render()
    {
        return view('livewire.form-upload');
    }

    public function submitForm()
    {
        $this->validate();

        $this->reset();
    }
}
