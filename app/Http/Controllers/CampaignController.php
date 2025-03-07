<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Template;
use App\Models\EmailList;
use App\Mail\EmailCampaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CampaignStoreRequest;
use App\Jobs\SendEmailCampaign;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CampaignController extends Controller
{
    use Conditionable;

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
        $data = session()->get('campaign', [
            'name' => null,
            'subject' => null,
            'email_list_id' => null,
            'template_id' => null,
            'body' => null,
            'track_click' => null,
            'track_open' => null,
            'send_at' => null,
            'send_when' => 'now',
        ]);

        return view('campaigns.create', 
        array_merge(
            $this->when(blank($tab), fn() =>  [
                    'emailLists' => EmailList::select(['id', 'title'])->orderBy('title')->get(),
                    'templates' => Template::query()->select(['id', 'name'])->orderBy('name')->get(),
            ], fn() => [])
            ,
            $this->when($tab == 'schedule', fn() => [
                'countEmails' => EmailList::find($data['email_list_id'])->subscribers()->count(),
                'template'=> Template::find($data['template_id'])->name
            ], fn() => []),
            [
                'tab'=> $tab,
                'form'=> match($tab){
                    'template' => '_template',
                    'schedule' => '_schedule',
                    default => '_config'
                },
                'data' => $data,
            ], 
        ));
    }

    public function store(CampaignStoreRequest $request, string $tab = null){
        $data = $request->getData();
        $toRoute = $request->getToRoute();

        if($tab == 'schedule'){
            $campaign = Campaign::create($data);

            SendEmailCampaign::dispatchAfterResponse($campaign);
        }

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
