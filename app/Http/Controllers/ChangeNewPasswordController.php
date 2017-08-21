<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChangeNewPasswordController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('changenewuser.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
							'password' => 'required|string|min:6|confirmed',
        				]);
        $User = User::findOrFail($id);
        $User->update([
             	   'password' => bcrypt($request->password),
             	   'status_id' => 1,
             			]);
        alert()->success('Congrats!', 'You updated your password');
        return Redirect::route('home');
    }


}
