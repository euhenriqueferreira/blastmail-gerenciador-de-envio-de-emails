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

    public function create(){
        return view('campaigns.create');
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
