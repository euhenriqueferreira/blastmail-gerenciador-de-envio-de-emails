<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(EmailList $emailsList){
        $search = request()->search;
  
        return view('subscriber.index', [
            'emailsList' => $emailsList,
            'subscribers' => $emailsList->subscribers()
                ->with('emailList')
                ->when($search, fn($query) => $query->where('name', 'like', "%$search%"))
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('id', '=', $search)
                ->paginate(),
            'search' => $search
        ]);
    }
}
