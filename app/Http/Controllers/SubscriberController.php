<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Http\Request;

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
                ->paginate(),
            'search' => $search,
            'showTrash' => $showTrash
        ]);
    }

    public function destroy(mixed $emailList, Subscriber $subscriber){
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted from the list'));
    }
}
