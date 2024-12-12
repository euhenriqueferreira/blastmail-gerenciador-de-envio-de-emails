<x-layouts.app>
    <x-slot name="header">
        <x-h2>{{ __('Templates') }}</x-h2>
    </x-slot>

    <x-card class="space-y-4">
        @unless($templates->isEmpty() && blank($search))
            <div class="flex justify-between">
                <x-button.link :href="route('templates.create')">
                    {{ __('Create a new template') }}
                </x-button.link>

                <x-form :action="route('templates.index')" flat x-data x-ref="form" class="w-3/5 flex space-x-4 items-center">
                    <x-input.checkbox  value="1" name="withTrashed" :label="__('Show Deleted Records')" @click="$refs.form.submit()" :checked="$withTrashed" />
                    <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full"/>
                </x-form>
            </div>

            <x-table :headers="['#', __('Name'), __('Actions')]">

                <x-slot name="body">
                    @foreach ($templates as $template)
                        <tr>
                            <x-table.td class="w-1">{{ __($template->id) }}</x-table.td>
                            <x-table.td>{{ __($template->name) }}</x-table.td>
                            <x-table.td class="w-1">
                                <div class="flex items-center space-x-4 ">
                                    <x-button.link secondary :href="route('templates.show', $template)">{{ __('Preview') }}</x-button.link>
                                    <x-button.link secondary :href="route('templates.edit', $template)">{{ __('Edit') }}</x-button.link>
                                    @unless($template->trashed())
                                        <div>
                                            <x-form
                                                :action="route('templates.destroy', $template)" delete flat
                                                onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                <x-button.secondary type="submit">{{ __('Delete') }}</x-button.secondary>
                                            </x-form>
                                        </div>
                                    @else
                                        <x-badge danger>{{ __('Deleted') }}</x-badge>
                                    @endunless
                                </div>
                            </x-table.td>
                        </tr> 
                    @endforeach
                </x-slot>

            </x-table>
           
            {{ $templates->links() }}
        @else
            <div class="flex justify-center">
                <x-button.link :href="route('templates.create')">
                    {{ __('Create your first template') }}
                </x-button.link>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
