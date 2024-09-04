<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function accountOverview($id) {
        
        $user = User::findOrFail($id);
        $orders = $user->orders()->latest()->get();

        return view('account.overview', compact('user', 'orders'));
    }
}
