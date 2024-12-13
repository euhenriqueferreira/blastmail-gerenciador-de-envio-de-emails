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