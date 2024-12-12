<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Email List') }} > {{ $emailsList->title }} > {{ __('Subscribers') }} </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div class="flex justify-between">
            <x-button.link :href="route('subscribers.create', $emailsList)">
                {{ __('Add a new subscriber') }}
            </x-button.link>

            <x-form :action="route('subscribers.index', $emailsList)" flat x-data x-ref="form" class="w-3/5 flex space-x-4 items-center">
                <x-input.checkbox  value="1" name="showTrash" :label="__('Show Deleted Records')" @click="$refs.form.submit()" :checked="$showTrash" />
                <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full"/>
            </x-form>
        </div>

        <x-table :headers="['#', __('Name'), __('Email'), __('Actions')]">

            <x-slot name="body">
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <x-table.td class="w-1">{{ __($subscriber->id) }}</x-table.td>
                        <x-table.td>{{ __($subscriber->name) }}</x-table.td>
                        <x-table.td>{{ __($subscriber->email) }}</x-table.td>
                        <x-table.td class="flex items-center space-x-4 w-1">
                            @unless($subscriber->trashed())
                                <div>
                                    <x-form
                                        :action="route('subscribers.destroy', [$emailsList, $subscriber])" delete flat
                                        onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        <x-button.secondary type="submit">Delete</x-button.secondary>
                                    </x-form>
                                </div>
                            @else
                                <x-badge danger>{{ __('Deleted') }}</x-badge>
                            @endunless
                        </x-table.td>
                    </tr> 
                @endforeach
            </x-slot>

        </x-table>
        
        {{ $subscribers->links() }}
    </x-card>
</x-layouts.app>
