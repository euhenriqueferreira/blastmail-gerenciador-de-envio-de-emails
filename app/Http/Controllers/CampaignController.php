<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CampaignController extends Controller
{
    public function index(){
        $search = request()->get('search', null);
        $withTrashed = request()->get('withTrashed', false);

        return view('campaigns.index', [
            'campaigns'=> Campaign::query()
                ->when($withTrashed, fn($query) => $query->withTrashed())
                ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")
                    ->orWhere('id', '=', $search)
                )
                ->paginate(5)
                ->appends(compact('search', 'withTrashed')),
            'search'=> $search,
            'withTrashed'=> $withTrashed
        ]);
    }

    public function create(string $tab = null){
        session()->forget('campaigns::create');
        return view('campaigns.create', [
            'tab'=> $tab,
            'form'=> match($tab){
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config'
            },
            'data' => session()->get('campaigns::create', [
                'name' => null,
                'subject' => null,
                'email_list_id' => null,
                'template_id' => null,
                'body' => null,
                'track_click' => null,
                'track_open' => null,
                'sent_at' => null,
            ])
        ]);
    }

    public function store(string $tab = null){

        $toRoute = '';

        $map = array_merge([
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'sent_at' => null,
        ], request()->all());


        if(blank($tab)){
            request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
            ]);

            $toRoute = to_route('campaigns.create', ['tab'=> 'template']);
        }

        if($tab == 'template'){
            request()->validate([
                'body' => ['required'],
            ]);

            $toRoute = to_route('campaigns.create', ['tab'=> 'schedule']);
        }

        if($tab == 'schedule'){
            request()->validate([
                'sent_at' => ['required', 'date'],
            ]);

            $toRoute = to_route('campaigns.index');
        }

        // --
            $session = session('campaigns::create');
            if($session){
                foreach ($session as $key => $value) {
                    $newValue = data_get($map, $key);
                    if(filled($newValue)){
                        $session[$key] = $newValue;
                    }
                }
            }
        // --
        
        
        session()->put('campaigns::create', $session);
        return $toRoute;
    }


    public function destroy(Campaign $campaign){
        $campaign->delete();

        return back()->with('message', 'Campaign successfully deleted!');
    }

    public function restore(Campaign $campaign){
        $campaign->restore();

        return back()->with('message', 'Campaign successfully restored!');
    }
}
