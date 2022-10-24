<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupChat;
use Illuminate\Support\Facades\Auth;

class GroupRepository{

    protected $group, $groupChat;

    public function __construct(Group $group, GroupChat $groupChat)
    {

        $this->group = $group;
        $this->groupChat = $groupChat;

    }

    public function create($data)
    {
        return $this->group->create($data);
    }

    public function fetchRecords()
    {

        return $this->group->all();
    }

    public function findById($id){
      return  $this->group->find($id);
    }

    public function createGroupChat($data)
    {
        return $this->groupChat->create($data);
    }



}
