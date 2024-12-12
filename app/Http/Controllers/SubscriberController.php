<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    public function index(EmailList $emailsList){
        $search = request()->search;
        $showTrash = request()->get('showTrash', false);
  
        return view('subscriber.index', [
            'emailsList' => $emailsList,
            'subscribers' => $emailsList->subscribers()
                ->with('emailList')
                ->when($showTrash, fn($query) => $query->withTrashed())
                ->when($search, fn($query) => $query->where('name', 'like', "%$search%"))
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('id', '=', $search)
                ->paginate()
                ->appends(compact('search', 'withTrashed')),
            'search' => $search,
            'showTrash' => $showTrash
        ]);
    }

    public function create(EmailList $emailsList){
        return view('subscriber.create', compact('emailsList'));
    }

    public function store(EmailList $emailsList){
        $data = request()->validate([
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'email', 'max:255', Rule::unique('subscribers')->where('email_list_id', $emailsList->id)],
        ]);

        $emailsList->subscribers()->create($data);

        return to_route('subscribers.index', $emailsList)->with('message', __('Subscriber successfully created!'));
    }


    public function destroy(mixed $emailList, Subscriber $subscriber){
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted from the list'));
    }
}
