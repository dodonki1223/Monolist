<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Item;

class UsersController extends Controller
{
    
    public function show($id)
    {
        $user       = User::find($id);
        $count_want = $user->want_items()->count();
        $count_have = $user->want_items()->count(); //修正する必要あり
         $items      = \DB::table('items')->join('item_user', 'items.id', '=', 'item_user.item_id')
                                          ->select('items.*')
                                          ->where('item_user.user_id', $user->id)
                                          ->distinct()
        //                                  ->groupBy('items.id')                                   //あとでどうするべきか考える事！！
                                          ->paginate(20);

        return view('users.show', [
            'user'       => $user,
            'items'      => $items,
            'count_want' => $count_want,
            'count_have' => $count_have,
        ]);

    }


}
