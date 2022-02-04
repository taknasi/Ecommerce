<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Category::child()->orderBy('id', 'DESC')->paginate(pagination_count);
        return view('dashboard.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainCategories = Category::parente()->orderBy('id', 'DESC')->get();
        return view('dashboard.subcategories.create', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoriesRequest $request)
    {
        try {
            if ($request->has('is_active')) {
                $request->request->add(['is_active' => 1]);
            } else $request->request->add(['is_active' => 0]);

            $subCat = Category::create($request->all());
            return redirect()->route('subCategory.index')->with(['success' => 'تم الاضافة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('subCategory.index')->with(['errors' => 'خطأ']);
        }
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
        $mainCat=Category::parente()->orderBy('id','DESC')->get();
        $subCat=Category::find($id);
        return view('dashboard.subcategories.edit',compact(['mainCat','subCat']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoriesRequest $request, $id)
    {
        $subCat=Category::find($id);
        if($subCat){
            if ($request->has('is_active')) {
                $request->request->add(['is_active' => 1]);
            } else $request->request->add(['is_active' => 0]);

            $subCat->update(
                $request->all()
            );
            return redirect()->route('subCategory.index')->with(['success' => 'تم التعديل بنجاح']);
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
        $subCat=Category::find($id);
        if($subCat){
            $subCat->translations()->delete();
            $subCat->delete();
        }
        return redirect()->route('subCategory.index')->with(['success' => 'تم الحذف بنجاح']);
    }
}
