<?php

namespace App\Http\Controllers;

use App\Events\GroupMessageEvent;
use App\Models\GroupChat;
use Illuminate\Http\Request;
use App\Service\GroupService;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }


    public function index()
    {

        $groups = $this->groupService->groupList();
        return view('chat_groups.groups' ,compact('groups'));

    }


    public function create()
    {
        return view('chat_groups.groups');
    }
    public function store(Request $request)
    {
        try {
            // Store groups
          $group =  $this->groupService->storeGroup($request->all());
          return redirect()->back();

        } catch (\Exception $e) {
            return 400;
        }


    }


     public function showGroup($id)

    {
        try {
            $group = $this->groupService->findGroup($id);
            return view('chat_groups.group-chat', compact('group'));
        } catch (\Exception $e) {
            info($e->getMessage());
        }


    }

    public function sendGroupMessage(Request $request, $id)
    {
        try {
            $user = auth()->user();
            $message = $this->groupService->sendGroupMessage($request->all(), $id);
            broadcast(new GroupMessageEvent($user, $message->message))->toOthers();

            return ['status' => 'Message Sent!'];
        } catch (\Exception $e) {

            info($e->getMessage());

        }

    }

    public function showGroupMesasages($id)
    {
        try {
            $groupMessage = GroupChat::with('user')->where('group_id', $id)->get();
            return response()->json($groupMessage);
        } catch (\Exception $e) {
            info($e->getMessage());
        }

    }


}
