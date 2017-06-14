<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['data'=>$users],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules =[
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed'
        ];

       $this->validate($request,$rules);

        $fields = $request->all();


        $user['password'] = bcrypt($request->password);
        $user['verified'] = User::USER_NOT_VERIFY;
        $user['verification_token'] = User::generateVarificationToken();
        $user['admin'] = User::USER_NOT_ADMINISTRATOR;


      $user = User::create($fields);

          return response()->json(['data'=>$user],201);
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

        return response()->json(['data'=>$user],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = User::findOrFail($id);

      $rules =[
        'email' => 'email|unique:users,email,'.$user->id, //unico no se aplica si es el mismo usuario quque hace el cambio
        'password' => 'min:6|confirmed',
        'admin' => 'in:'.User::USER_NOT_ADMINISTRATOR.','.User::USER_ADMINISTRATOR,
      ];

    if($request->has('name')){
      $user->name = $request->name;
    }

    if($request->has('email') && $user->email != $request->emial){
      $user->verified = User::USER_NOT_VERIFY;
      $user->verification_token = User::generateVarificationToken();
      $user->email = $request->email;
    }

    if($request->has('password')){
      $user->password = bcrypt($request->password);
    }

    if($request->has('admin')){
      if(!$user->isVerify()){
          $msg = 'Unicamente los usuario verificados pueden hacer cambios';
         return response()
         ->json([
           'error'=> $msg,
           'code' => 409
         ], 409);
      }

      $user->admin = $request->admin;

    }

//validar si se han echo cambios entre la peticion y el onjeto de bdd
    if(!$user->isDirty()){
      $msg = 'Debes hacer cambios en almenos un valor enviado';
     return response()
     ->json([
       'error'=> $msg,
       'code' => 422
     ], 422);
    }

    $user->save();

        return response()->json(['data'=>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      $user->delete();
      return response()->json(['data'=>$user],200);
    }
}
