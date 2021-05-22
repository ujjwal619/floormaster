<?php

namespace App\FMS\User\Queries;

use Illuminate\Http\Request;

class UserList
{
    public function fetch(Request $request)
    {
        $user =  $request->user();
        return $user->newQuery()
            ->select(
                'id',
                'username'
            )
            ->get()
            ->toArray();
    }
}
