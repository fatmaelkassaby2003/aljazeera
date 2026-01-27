<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex flex-wrap items-center gap-4 justify-start">
            {{ $this->getFormActions()[0] }}
        </div>
    </form>
</x-filament-panels::page>
