<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController {

    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store','update']);
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::all();
		return $this->showAll($users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$rules = [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
		];
		$this->validate($request, $rules);
		$input = $request->all();
		$input['password'] = bcrypt($request->password);
		$input['verified'] = User::UNVERIFIED_USER;
		$input['verification_token'] = User::generateVerificationCode();
		$input['admin'] = User::REGULAR_USER;
		$user = User::create($input);
		return $this->showOne($user, 201);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user) {

		return $this->showOne($user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user) {

		$rules = [
			'password' => 'required|min:6',
			'email' => 'email|unique:users,email,' . $user->id,
			'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
		];
		$this->validate($request, $rules);
		if ($request->has('name')) {
			$user->name = $request->name;
		}
		if ($request->has('email') && $user->email != $request->email) {
			$user->verified = User::UNVERIFIED_USER;
			$user->verification_token = User::generateVerificationCode();
			$user->email = $request->email;
		}
		if ($request->has('password')) {
			$user->password = bcrypt($request->password);
		}
		if ($request->has('admin')) {
			if (!$user->isVerified()) {
				return $this->errorResponse('Only Verified User can modify the admin field', 409);
			}
			$user->admin = $request->admin;
		}
		if (!$user->isDirty()) {
			return $this->errorResponse('You need to specify different value to update', 422);
		}
		$user->save();
		return $this->showOne($user);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user) //Model binding
	{
		// $user=User::findOrFail($id);
		$user->delete();
		return $this->showOne($user);
	}

    /**
     * @param $token
     */
    public function verify($token){
	    $user=User::where('verification_token',$token)->firstOrFail();
	    $user->verified=User::VERIFIED_USER;
	    $user->verification_token=null;
	    $user->save();
	    return $this->showMessage('User has been verified successfully',200);

    }
    public function resend(User $user){
        if($user->isVerified()){
            return $this->errorResponse('This user is already Verified.',409);
        }
        retry(5,function () use($user){
            Mail::to($user)->sende(new UserCreated($user));
        },100);

        return $this->showMessage('Verification Email has been resent successfully',200);
    }

}
