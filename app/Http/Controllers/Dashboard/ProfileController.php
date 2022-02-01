<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth('admin')->user();
        return \view('dashboard.profile.edit', \compact('admin'));
    }

    // public function update(ProfileRequest $request, $id)
    // {
    //     try {
    //         $admin = Admin::find($id)->first();
    //         if ($admin) {
    //             DB::beginTransaction();
    //             $admin->update([
    //                 'name' => $request->name,
    //                 'email' => $request->email
    //             ]);
    //             if ($request->filled('password')) {
    //                 $admin->password = bcrypt($request->password);
    //             }
    //             $admin->save();
    //             DB::commit();
    //             return redirect()->back()->with(['success' => 'تم التعديل بنجاح']);
    //         }
    //         return redirect()->bach()->with(['error' => 'خطأ']);
    //     } catch (\Exception $ex) {
    //         //throw $th;
    //     }
    // }
    public function update(ProfileRequest $request, $id)
    {
        try {
            $admin = Admin::find($id)->first();
            if ($admin) {
                DB::beginTransaction();

                unset($request['id']);
                unset($request['password_confirmation']);

                if ($request->filled('password')) {
                    $request->merge(['password' => bcrypt($request->password)]);
                } else {
                    unset($request['password']);
                }
                $admin->update($request->all());

                DB::commit();
                return redirect()->back()->with(['success' => 'تم التعديل بنجاح']);
            }
            return redirect()->back()->with(['error' => 'خطأ']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }
}
