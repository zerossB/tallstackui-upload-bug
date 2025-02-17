<div>
    <div class="mx-auto max-w-2xl py-4 px-4">
        <form wire:submit="submitForm" class="space-y-4">
            <x-input label="Name" hint="Insert your name" wire:model="email"/>

            <x-upload label="Upload File" hint="Upload a file" delete multiple wire:model="file"/>

            <x-button type="submit" sm>
                Submit
            </x-button>
        </form>
    </div>
</div>
