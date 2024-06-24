<?php

namespace App\Http\Controllers\Backend;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;


class UserController extends Controller
{

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $users = User::paginate(20);
        return view('backend.pages.users.index', compact('users'));
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('backend.pages.users.edit');
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(UserRequest $request)
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => $request->is_admin,
            'status' => $request->status,
        ]);
        return back()->withSuccess('Başarıyla Oluşturuldu!');
    }

    /**
    * Display the specified resource.
    */
    public function show(string $id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        $users = User::where('id',$id)->first();
        return view('backend.pages.users.edit' , compact('users'));

    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UserRequest $request, string $id)
    {

        $users = User::where('id', $id)->firstOrFail();

        $users->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => $request->is_admin,
            'status' => $request->status,
        ]);
        return back()->withSuccess('Başarıyla Güncellendi!');
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Request $request,)
    {
        $users = User::where('id',$request->id)->firstOrFail();


        $users->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function status(Request $request){
        $update = $request->statu;
        $updatecheck = $update == "false" ? '0' : '1';

        Product::where('id', $request->id)->update(['status'=>$updatecheck]);
        return response(['error'=>false,'status'=>$update]);
    }
}
