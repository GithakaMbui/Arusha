<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('admin.doctor.index', compact('users')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       $this->validateStore($request);
       $data = $request->all();
       $photo = $request->file('photo');
       $name = $photo->hashName();
       $destination = public_path('/images');
       $photo->move($destination, $name);
        $data['photo'] = $name;
       $data['password'] = bcrypt($request->password);
       User::create($data);

       return redirect()->back()->with('message', 'Doctor added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.doctor.edit', compact('user'));
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
        $this->validateUpdate($request, $id);
        $data = $request->all(); 
        $user = User::find($id);
        $imageName=$user->photo;
        $userPassword = $user->password;
        if($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = $photo->hashName();
            $destination = public_path('/images');
            $photo->move($destination, $imageName);
        }  
            $data['photo'] = $imageName;

        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }else{
            $data['password'] = $userPassword;
        }

        $user->update($data);
        return redirect()->route('doctor.index')->with('message', 'Doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateStore($request){

      return  $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'email' => 'required|min:6|max:25',
            'gender' => 'required',
            'npi_number' => 'required',
            'address' => 'required',
            'department' => 'required',
            'phone_number' => 'required|numeric',
            'photo' => 'required|mimes:jpeg,jpg,png',
            'role_id' => 'required',
            'description' => 'required',
       ]);

    }

      public function validateUpdate($request, $id){

      return  $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'email' => 'required|min:6|max:25',
            'gender' => 'required',
            'npi_number' => 'required',
            'address' => 'required',
            'department' => 'required',
            'phone_number' => 'required|numeric',
            'photo' => 'mimes:jpeg,jpg,png',
            'role_id' => 'required',
            'description' => 'required',
       ]);

    }
}
