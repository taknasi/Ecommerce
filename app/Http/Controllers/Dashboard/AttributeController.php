<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes=Attribute::orderBy('id','desc')->paginate(pagination_count);
        return view('dashboard.attributes.index',compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
        Attribute::create([
            'name' => $request->name
        ]);
        return redirect()->route('attributes.index')->with(['success' => 'تم  بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute=Attribute::with('translations')->whereId($id)->first();
        // if($attribute){
        //     return \view('dashboard.attributes.edit',compact('attribute'));
        // }return $attribute->translations()->locale;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, $id)
    {
        $attribute=Attribute::find($id);
        if($attribute){
            $attribute->name=$request->name;
            $attribute->save();
            return redirect()->route('attributes.index')->with(['success' => 'تم  بنجاح']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute=Attribute::find($id);
        if($attribute){
            $attribute->translations()->delete();
            $attribute->delete();
            return redirect()->route('attributes.index')->with(['success' => 'تم  بنجاح']);
        }
       
    }
}
