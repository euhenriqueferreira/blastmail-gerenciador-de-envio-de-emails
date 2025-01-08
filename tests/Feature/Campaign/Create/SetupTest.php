<?php

use App\Models\EmailList;
use App\Models\Template;

use function Pest\Laravel\post;

beforeEach(function(){
    login();

    $this->route = route('campaigns.create');
});

test('when saving we need to update campaigns::create session to have all the data', function(){
    EmailList::factory()->create();
    $template = Template::factory()->create();
    
    post($this->route, [
        'name' => 'First Campaign',
        'subject' => 'Subject',
        'email_list_id' => 1,
        'template_id' => 1,
        'track_click' => true,
        'track_open' => true,
    ]);

    expect(session()->get('campaigns::create'))
        ->toBe([
            'name' => 'First Campaign',
            'subject' => 'Subject',
            'email_list_id' => 1,
            'template_id' => 1,
            'body' => $template->body,
            'track_click' => true,
            'track_open' => true,
            'send_at' => null,
            'send_when' => 'now',
        ]);
});

test('make sure that when we save the form we will be redirect back to the template tab', function(){
    EmailList::factory()->create();
    $template = Template::factory()->create();
    
    post($this->route, [
        'name' => 'First Campaign',
        'subject' => 'Subject',
        'email_list_id' => 1,
        'template_id' => 1,
        'track_click' => true,
        'track_open' => true,
    ])->assertRedirect(route('campaigns.create', ['tab' => 'template']));

});

test('it should have on the view a list of email lists', function(){

})->todo();

test('it should have on the view a list of templates', function(){

})->todo();

test('it should have on the view a blank tab variable', function(){

})->todo();

test('it should have on the view the form variable set to _config', function(){

})->todo();

test('it should have on the view all the data in the session in the variable data', function(){

})->todo();

test('if session is clear the variable data should have a default value', function(){

})->todo();

// --
describe('validations', function(){
    test('require fields', function() {})->todo();
    test('name should have a max of 255 characters', function() {})->todo();
    test('subject should have a max of 40 characters', function() {})->todo();
    test('valid email list', function() {})->todo();
    test('valid template', function() {})->todo();
});