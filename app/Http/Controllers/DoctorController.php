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
       $name = (new User)->useAvatar($request);
       
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
        $user = User::find($id);
        return view('admin.doctor.delete',compact('user'));
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
            
            $imageName = (new User)->useAvatar($request);
            unlink(public_path('images/'.$user->image));    
       
        
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
    // Check if the user is authenticated
    if (!auth()->check()) {
        return redirect()->back()->with('error', 'You must be logged in to perform this action.');
    }

    // Prevent the authenticated user from deleting themselves
    if (auth()->user()->id == $id) {
        return redirect()->back()->with('error', 'You cannot delete your own account.');
    }

    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    $userDelete = $user->delete();

    if ($userDelete) {
        if (file_exists(public_path('images/'.$user->photo))) {
            unlink(public_path('images/'.$user->photo));
        }
    }

    return redirect()->back()->with('message', 'Doctor deleted successfully');
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
