<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Email List') }} > {{ $emailsList->title }} {{ __('Add a new subcriber') }}</x-h2>
    </x-slot>

    <x-card>
        <x-form :action="route('subscribers.create', $emailsList)" post>

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-input.text id="name" class="block mt-1 w-full" name="name" :value="old('name')" autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-input.text id="email" class="block mt-1 w-full" type="email" accept=".csv" name="email" autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center space-x-4">
                <x-button.link secondary :href="route('subscribers.index', $emailsList)">
                    {{ __('Cancel') }}
                </x-button.link>
                
                <x-button type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>
        </x-form>
    </x-card>
</x-layouts.app>