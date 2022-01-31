<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class settingController extends Controller
{
    public function editShippingMethods($type)
    {
        if ($type == "inner") {
            $shippingMethod = Setting::where('key', 'local_label')->first();
            return view('dashboard.settings.shipping.edit', compact('shippingMethod'));
        } else if ($type == "outer") {
            $shippingMethod = Setting::where('key', 'outer_label')->first();
            return view('dashboard.settings.shipping.edit', compact('shippingMethod'));
        } else if ($type == "free") {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
            return view('dashboard.settings.shipping.edit', compact('shippingMethod'));
        }
    }

    public function updateShippingMethods(SettingRequest $req, $id)
    {

        try {
            $shippingMethod = Setting::find($id);
            if ($shippingMethod) {
                DB::beginTransaction();
                $shippingMethod->update(
                    [
                        'value' => $req->value,
                        'plain_value' => $req->plain_value
                    ]
                );
                $shippingMethod->save();
                DB::commit();
                return redirect()->back()->with(['success' => 'تم التعديل بنجاح']);
            } else
                return redirect()->back()->with(['errors' => 'خطأ']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['errors' => 'ex خطأ']);
            DB::rollback();
        }
    }
}
