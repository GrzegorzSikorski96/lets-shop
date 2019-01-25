<?php

namespace App\Observers;

use App\Models\Group;
use App\Models\Shop;

class GroupObserver
{

    public function created(Group $group)
    {
        Shop::create(['group_id' => $group->id, 'name' => "Auchan"]);
        Shop::create(['group_id' => $group->id, 'name' => "Kaufland"]);
        Shop::create(['group_id' => $group->id, 'name' => "Lidl"]);
        Shop::create(['group_id' => $group->id, 'name' => "Biedronka"]);
        Shop::create(['group_id' => $group->id, 'name' => "TESCO"]);
    }

}
