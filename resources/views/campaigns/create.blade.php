<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Campaigns') }} > {{ __('Create a new campaign') }}</x-h2>
    </x-slot>

    <x-card>
        <x-tabs :tabs="[
            __('Setup') => 'campaigns.create',
            __('Email Body') => 'campaigns.create.template',
            __('Schedule') => 'campaigns.create.schedule'
        ]">

            <x-form :action="route('campaigns.create')" post>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input.text id="name" class="block mt-1 w-full" name="name" :value="old('name')" autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="subject" :value="__('Subject')" />
                        <x-input.text id="subject" class="block mt-1 w-full" accept=".csv" name="subject" autofocus />
                        <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email_list_id" :value="__('Email List')" />
                        <x-input.text id="email_list_id" class="block mt-1 w-full" accept=".csv" name="email_list_id" autofocus />
                        <x-input-error :messages="$errors->get('email_list_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="template_id" :value="__('Template')" />
                        <x-input.text id="template_id" class="block mt-1 w-full" accept=".csv" name="template_id" autofocus />
                        <x-input-error :messages="$errors->get('template_id')" class="mt-2" />
                    </div>
                </div>
    
                <div class="flex items-center space-x-4">
                    <x-button.link secondary :href="route('campaigns.index')">
                        {{ __('Cancel') }}
                    </x-button.link>
                    
                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </x-form>
        </x-tabs>
            


   
    </x-card>
</x-layouts.app>
