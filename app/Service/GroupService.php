<?php

namespace App\Service;
use App\Events\GroupMessageEvent;
use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Support\Str;

class GroupService{
    protected $groupRepositor;

    public function __construct(GroupRepository $groupRepositor){
        $this->groupRepositor = $groupRepositor;
    }

    public function storeGroup($data){
        $groupName = $data['name'];
        $userId = auth()->user()->id;
        $groupCode = Str::random(40);
        $data = [
            'name' => $groupName,
            'code' => $groupCode,
            'user_id' => $userId
        ];
        return $this->groupRepositor->create($data);
    }

    public function groupList()
    {

        return $this->groupRepositor->fetchRecords();
    }

    public function findGroup($id){
        return $this->groupRepositor->findById($id);
    }

    public function sendGroupMessage($data, $id)
    {


        $group = Group::find($id);
        $user = auth()->user()->id;
        $data = ['user_id' => $user, 'group_id' => $group->id ,'message' => $data['message']];
        return $this->groupRepositor->createGroupChat($data);
    }
}


