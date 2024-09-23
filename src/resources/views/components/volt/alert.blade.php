<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component
{
    public string $type = 'primary';
    public ?string $message = null;
    public bool $show = false;

    public function mount(): void
    {
        if (alert()->has()) {
            $this->make(
                type: alert()->get()->type(),
                message: alert()->get()->message()
            );
        }
    }

    #[On('makeAlert')]
    public function make(string $type, string $message): void
    {
        $this->type = $type;
        $this->message = $message;
        $this->show = true;
        $this->dispatch('alert');
    }

    public function close(): void
    {
        $this->reset();
    }
} ?>

<div
    x-data="{
        show: false,
        timeout: null,
        showAlert() {
            clearTimeout(this.timeout);
            this.show = true;
            this.timeout = setTimeout(() => { this.show = false }, 5000);
        }
    }"
    x-init="
        @if(alert()->has())
            showAlert();
        @endif
    "
    x-on:alert="showAlert"
>
    <div
        x-show="show"
        style="display: none;"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-48 scale-80"
        x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 transform scale-80 -translate-y-24"
        class="fixed right-0 top-0 flex flex-col justify-end items-end w-full max-w-md p-4 z-50 pointer-events-none"
    >
        <div @class([
            'flex flex-row justify-between items-start p-2 rounded-md shadow',
            'bg-light-primary dark:bg-dark-primary text-light-on-primary dark:text-dark-on-primary' => $type == 'primary',
            'bg-light-secondary dark:bg-dark-secondary text-light-on-secondary dark:text-dark-on-secondary' => $type == 'secondary',
            'bg-light-tertiary dark:bg-dark-tertiary text-light-on-tertiary dark:text-dark-on-tertiary' => $type == 'tertiary',
            'bg-light-error dark:bg-dark-error text-light-on-error dark:text-dark-on-error' => $type == 'error',
        ])>
            <div class="flex flex-row items-start">
                <div @class([
                    'p-2 rounded-lg',
                    'bg-light-on-primary/8 dark:bg-dark-on-primary/8' => $type == 'primary',
                    'bg-light-on-secondary/8 dark:bg-dark-on-secondary/8' => $type == 'secondary',
                    'bg-light-on-tertiary/8 dark:bg-dark-on-tertiary/8' => $type == 'tertiary',
                    'bg-light-on-error/8 dark:bg-dark-on-error/8' => $type == 'error',
                ])>
                    @switch($type)
                        @case('tertiary')
                            <x-icon::light-bulb type="mini" />
                            @break
                        @case('secondary')
                            <x-icon::information-circle type="mini" />
                            @break
                        @case('primary')
                            <x-icon::face-smile type="mini" />
                            @break
                        @case('error')
                            <x-icon::face-frown type="mini" />
                            @break
                    @endswitch
                </div>
                <div class="self-center px-2 font-medium text-sm">{{ $message }}</div>
            </div>
            <div
                x-on:click="show = false" @class([
                'p-2 rounded-lg cursor-pointer transition pointer-events-auto',
                'hover:bg-light-on-primary/8 dark:hover:bg-dark-on-primary/8' => $type == 'primary',
                'hover:bg-light-on-secondary/8 dark:hover:bg-dark-on-secondary/8' => $type == 'secondary',
                'hover:bg-light-on-tertiary/8 dark:hover:bg-dark-on-tertiary/8' => $type == 'tertiary',
                'hover:bg-light-on-error/8 dark:hover:bg-dark-on-error/8' => $type == 'error',
            ])>
                <x-icon::x-mark type="mini" />
            </div>
        </div>
    </div>

</div>
