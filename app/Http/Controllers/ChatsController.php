<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageEvent;
use App\Events\MessageSent;
use App\Models\Group;
use App\Models\GroupChat;
use App\Models\Message;
use App\Service\GroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class ChatsController extends Controller
{
     //Add the below functions
     protected $groupService;
     public function __construct(GroupService $groupService)
     {
         $this->groupService = $groupService;
         $this->middleware('auth');
     }
    public function index(Group $group)
    {
        return view('chat',compact('group'));
    }

    public function fetchMessages(Group $group)
    {
        return $group->groupChat()->with('user')->get();
    }

    public function sendMessage(Request $request,$groupID)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            "group_id"=>$groupID
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();
        return ['status' => 'Message Sent!'];
    }
}
