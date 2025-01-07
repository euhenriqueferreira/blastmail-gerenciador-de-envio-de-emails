<?php

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

beforeEach(function(){
    $this->emailList = EmailList::factory()->create();

    login();
});

it('only logged users can access the subscribers', function() {
    Auth::logout();

    getJson(route('subscribers.index', $this->emailList))
    ->assertUnauthorized();
});

it('should be possible to see the entire list of subscribers', function() {
    Subscriber::factory()->count(5)->create([
        'email_list_id' => $this->emailList->id
    ]);
    Subscriber::factory()->count(4)->create();

    
    get(route('subscribers.index', $this->emailList))
        ->assertViewHas('emailsList', $this->emailList)
        ->assertViewHas('subscribers', function($value){
            expect($value)
                ->count(5);
                
                expect($value)->first()->email_list_id->toBe($this->emailList->id);

            return true;
        });
});
it('should be able to search a subscriber', function() {})->todo();
it('should be able to show deleted records', function() {})->todo();
it('should be paginated', function() {})->todo();