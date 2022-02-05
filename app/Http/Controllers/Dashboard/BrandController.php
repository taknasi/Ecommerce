<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(pagination_count);
        return view('dashboard.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $filePath = "";
        if ($request->has('photo')) {
            $filePath = uploadPhoto('brands', $request->photo);
        }
        if ($request->has('is_active'))
            $request->request->add(['is_active' => 1]);
        else
            $request->request->add(['is_active' => 0]);

        $brand = Brand::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);
        $brand->photo = $filePath;
        $brand->save();
        return redirect()->route('brands.index')->with(['success' => 'تم الاضافة بنجاح']);
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
        $brand = Brand::find($id);
        if ($brand) {
            return view('dashboard.brands.edit', compact('brand'));
        }
        return redirect()->route('brands.index')->with(['errors' => 'هذه الغلامة غير موجودة']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            if ($request->has('is_active'))
                $request->request->add(['is_active' => 1]);
            else
                $request->request->add(['is_active' => 0]);

            $brand->update([
                'name' => $request->name,
                'is_active' => $request->is_active,
            ]);
            $filePath = "";
            if ($request->has('photo')) {
                $filePath = uploadPhoto('brands', $request->photo);
                deletePhoto('brands', $brand->photo);
                $brand->photo = $filePath;
                $brand->save();
            }
            return redirect()->route('brands.index')->with(['success' => 'تم التعديل بنجاح']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->translations()->delete();
            deletePhoto('brands', $brand->photo);
            $brand->delete();
            return redirect()->route('brands.index')->with(['success' => 'تم الحذف بنجاح']);
        } else {
            return redirect()->route('brands.index')->with(['errors' => 'خطأ']);
        }
       
    }
}
