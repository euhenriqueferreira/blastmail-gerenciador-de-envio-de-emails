<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Campaigns') }}</x-h2>
    </x-slot>

    <x-card class="space-y-4">
        @unless($campaigns->isEmpty() && blank($search))
            <div class="flex justify-between">
                <x-button.link :href="route('campaigns.create')">
                    {{ __('Create a new campaign') }}
                </x-button.link>

                <x-form :action="route('campaigns.index')" flat x-data x-ref="form" class="w-3/5 flex space-x-4 items-center">
                    <x-input.checkbox  value="1" name="withTrashed" :label="__('Show Deleted Records')" @click="$refs.form.submit()" :checked="$withTrashed" />
                    <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full"/>
                </x-form>
            </div>

            <x-table :headers="['#', __('Name'), __('Actions')]">

                <x-slot name="body">
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <x-table.td class="w-1">{{ __($campaign->id) }}</x-table.td>
                            <x-table.td>{{ __($campaign->name) }}</x-table.td>
                            <x-table.td class="w-1">
                                <div class="flex items-center space-x-4 ">
                                    @unless($campaign->trashed())
                                        <div>
                                            <x-form
                                                :action="route('campaigns.destroy', $campaign)" delete flat
                                                onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                <x-button.secondary type="submit">{{ __('Delete') }}</x-button.secondary>
                                            </x-form>
                                        </div>
                                    @else
                                        <div>
                                            <x-form
                                                :action="route('campaigns.restore', $campaign)" patch flat
                                                onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                <x-button.secondary danger type="submit">{{ __('Restore') }}</x-button.secondary>
                                            </x-form>
                                        </div>
                                        <x-badge danger>{{ __('Deleted') }}</x-badge>
                                    @endunless
                                </div>
                            </x-table.td>
                        </tr> 
                    @endforeach
                </x-slot>

            </x-table>
           
            {{ $campaigns->links() }}
        @else
            <div class="flex justify-center">
                <x-button.link :href="route('campaigns.create')">
                    {{ __('Create your first campaign') }}
                </x-button.link>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
