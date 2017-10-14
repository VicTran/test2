<?php
namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Mail\EmailVerificationtoUser;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Redirect;
class UserController extends Controller
{




    public function __construct()
    {
        $this->middleware('auth',['except' => 'index']);
        $this->middleware('admin', ['except' => 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        
        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                                    'name' => 'required|string|max:255',
                                    'email' => 'required|string|email|max:255|unique:users',
                                    'phonenumber' => 'required|numeric',
                                    'password' => 'required|string|min:6|confirmed',
                                    ]);
        
        $user = User::create([
                                    'name' => $request->name,
                                    'email' => $request->email,
                                    'phonenumber' => $request->phonenumber,
                                    'password' => bcrypt($request->password),
                                    'email_token' => str_random(10),
                                    'status_id' => 10,
                                    'verified' => true
                                 ]);
        $email = new EmailVerificationtoUser(new User(['email_token' => $user->email_token, 'name' => $user->name, 'email' => $user->email, 'password' => $request->password ]));
         Mail::to($user->email)->send($email);
        alert()->success('Congrats!', 'You made new User');
        return redirect('user');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->profile;
        return view('user.show', compact('user', 'profile'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->updateUser($user, $request);
        alert()->success('Congrats!', 'You updated a user');
        return Redirect::route('user.show', ['user' => $user]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        alert()->overlay('Attention!', 'You deleted a user', 'error');
        return Response::json($user);
    }
    public function delete(Request $request){
        $user_id = $request['user_id'];
        $user = User::destroy($user_id);
        return 'ok';
    }

}