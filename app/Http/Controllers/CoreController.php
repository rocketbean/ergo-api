<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ErgoService;

use Illuminate\Http\Request;

class CoreController extends Controller
{
    /**
     * Creates The first admin [user]
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createFirstUser() {
        $user = ErgoService::GetUser();
        return User::create($user);
    }
}
