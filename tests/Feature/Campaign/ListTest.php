<?php

use App\Models\EmailList;
use App\Models\Subscriber;
use App\Models\Campaign;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(function(){
    login();
});

it('only logged users can access the campaigns', function() {
    Auth::logout();

    getJson(route('campaigns.index'))
    ->assertUnauthorized();
});

it('should be possible to see the entire list of campaigns', function() {
    Campaign::factory()->count(5)->create();

    get(route('campaigns.index'))
        ->assertViewHas('campaigns', function($value){
            expect($value)
                ->count(5);

            return true;
        });
});

it('should be able to search a campaign by name', function() {
    Campaign::factory()->create(['name' => 'Joao Gomes']);
    Campaign::factory()->create(['name' => 'Julia Santos']);

    // Filtrar com name
    get(route('campaigns.index', ['search' => 'Joao']))
        ->assertViewHas('campaigns', function($value){
            expect($value)
                ->count(1);
            
                expect($value)->first()->id->toBe(1);

            return true;
        });
});

it('should be able to search a campaign by id', function(){
    withoutExceptionHandling();
    Campaign::factory()->count(2)->create();

    // Filtrar com id
    get(route('campaigns.index', ['search' => 2]))
    ->assertViewHas('campaigns', function($value){
        expect($value)
            ->count(1);

            expect($value)->first()->id->toBe(2);

        return true;
    });
});

it('should be able to show deleted records', function() {
    Campaign::factory()->create([
        'deleted_at' => now()
    ]);

    Campaign::factory()->create();

    get(route('campaigns.index'))
    ->assertViewHas('campaigns', function($value){
        expect($value)
            ->count(1);

        return true;
    });

    get(route('campaigns.index', ['withTrashed' => 1]))
    ->assertViewHas('campaigns', function($value){
        expect($value)
            ->count(2);

        return true;
    });
});

it('should be paginated', function() {
    Campaign::factory()->count(30)->create();

    // Filtrar com id
    get(route('campaigns.index'))
    ->assertViewHas('campaigns', function($value){
        expect($value)->count(5);
        expect($value)->toBeInstanceOf(LengthAwarePaginator::class);
        return true;
    });

});