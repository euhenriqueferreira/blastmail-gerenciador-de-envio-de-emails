<?php

use App\Models\EmailList;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

beforeEach(function(){
    $this->emailList = EmailList::factory()->create();
});

it('only logged users can access the subscribers', function() {
    getJson(route('subscribers.index', $this->emailList))
    ->assertUnauthorized();
});

it('should be possible to see the entire list of subscribers', function() {})->todo();
it('should be able to search a subscriber', function() {})->todo();
it('should be able to show deleted records', function() {})->todo();
it('should be paginated', function() {})->todo();