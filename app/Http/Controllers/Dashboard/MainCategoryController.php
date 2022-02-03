<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainCategories = Category::parente()->orderBy('id', 'DESC')->paginate(pagination_count);
        return view('dashboard.categories.index', compact('mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            if ($request->has('is_active'))
                $request->request->add(['is_active' => 1]);
            else
                $request->request->add(['is_active' => 0]);

            DB::beginTransaction();
            $category = Category::create(
                $request->all()
            );
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('MainCategory.index')->with(['success' => 'تم الاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('MainCategory.index')->with(['errors' => 'خطأ']);
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
        $category = Category::find($id);
        if ($category) {
            return view('dashboard.categories.edit', compact('category'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {

        try {
            $category = Category::find($id);
            if ($category) {
                $category->update(
                    [
                        'name' => $request->name,
                        'slug' => $request->slug,
                    ]
                );
                if ($request->has('is_active')) {
                    $category->is_active = 1;
                } else {
                    $category->is_active = 0;
                }
                $category->save();

                return redirect()->route('MainCategory.index')->with(['success' => 'تم التعديل بنجاح']);
            } else
                return redirect()->route('MainCategory.index')->with(['errors' => 'خطأ']);
        } catch (\Exception $ex) {
            return redirect()->route('MainCategory.index')->with(['errors' => 'خطأ']);
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
        try {
            $category = Category::find($id);
            if ($category) {
                DB::beginTransaction();
                $category->translations()->delete();
                $category->delete();
                DB::commit();
                return redirect()->route('MainCategory.index')->with(['success' => 'تم الحذف بنجاح']);
            } else {
                return redirect()->route('MainCategory.index')->with(['errors' => 'خطأ']);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('MainCategory.index')->with(['errors' => 'خطأ']);
        }
    }
}
