<?php

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\Template;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\put;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(function(){
    login();

    $this->template = Template::factory()->create([
        'name' => 'Template Master',
        'body' => '<span>Hello World!</span>'
    ]);

    $this->route = route('templates.update', $this->template);
});

it('should be able to update a new template', function() {
    withoutExceptionHandling();
    
    put($this->route, ['name' => 'Changed Name', 'body' => '<span>Has changed!</span>'])
        ->assertRedirect()
        ->assertSessionHas('message', 'Template successfully updated');

    assertDatabaseHas('templates', [
        'id' => $this->template->id,
        'name' => 'Changed Name',
        'body' => '<span>Has changed!</span>'
    ]);
});

test('name should be required', function() {
    put($this->route, ['name' => '', 'body' => '<span>Hello World!</span>'])
        ->assertSessionHasErrors(['name' => __('validation.required', ['attribute' => 'name'])]);
});

test('name should have a max of 255 character', function() {
    put($this->route, ['name' => str_repeat('*', 256), 'body' => '<span>Hello World!</span>'])
        ->assertSessionHasErrors(['name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255])]);
});

test('body should be required', function() {
    put($this->route, ['name' => 'Joe Doe', 'body' => ''])
    ->assertSessionHasErrors(['body' => __('validation.required', ['attribute' => 'body'])]);
});