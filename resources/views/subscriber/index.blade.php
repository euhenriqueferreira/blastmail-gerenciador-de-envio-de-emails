<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Email List') }} > {{ $emailsList->title }} > {{ __('Subscribers') }} </x-h2>
    </x-slot>

    <x-card class="space-y-4">
        <div class="flex justify-between">
            <x-link-button :href="route('subscribers.create', $emailsList)">
                {{ __('Add a new subscriber') }}
            </x-link-button>

            <x-form :action="route('subscribers.index', $emailsList)" class="w-2/5">
                <x-text-input name="search" :placeholder="__('Search')" :value="$search" />
            </x-form>
        </div>

        <x-table :headers="['#', __('Name'), __('Email'), __('Actions')]">

            <x-slot name="body">
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <x-table.td>{{ __($subscriber->id) }}</x-table.td>
                        <x-table.td>{{ __($subscriber->name) }}</x-table.td>
                        <x-table.td>{{ __($subscriber->email) }}</x-table.td>
                        <x-table.td>
                            //
                        </x-table.td>
                    </tr> 
                @endforeach
            </x-slot>

        </x-table>
        
        {{ $subscribers->links() }}
    </x-card>
</x-layouts.app>