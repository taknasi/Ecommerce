<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(pagination_count);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['categories'] = Category::select('id')->orderBy('id', 'desc')->get();
        $data['brands'] = Brand::select('id')->orderBy('id', 'desc')->get();
        $data['tags'] = Tag::select('id')->orderBy('id', 'desc')->get();
        return view('dashboard.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->has('is_active'))
                $request->request->add(['is_active' => 1]);
            else
                $request->request->add(['is_active' => 0]);

            $product = Product::create($request->only(['slug', 'is_active', 'brand_id']));
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();
            $product->categories()->attach($request->categories);
            $product->tags()->attach($request->tags);
            DB::commit();
            return \redirect()->route('products.index')->with(['success' => 'm3alem']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
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
        //
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
        //
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

    public function getPrice($product_id)
    {
        return view('dashboard.products.productPrices.create')->with('id', $product_id);
    }
    public function savePrice(ProductPriceRequest $request)
    {
        $product = Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));
        return \redirect()->route('products.index')->with(['success' => 'm3alem']);
    }

    public function getStock($product_id)
    {
        $product = Product::whereId($product_id)->select('sku', 'manage_stock', 'in_stock', 'qty')->first();
        return view('dashboard.products.stock.create', compact('product'))->with('id', $product_id);
    }

    public function saveStock(ProductStockRequest $request)
    {
        Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));
        return \redirect()->route('products.index')->with(['success' => 'm3alem']);
    }

    public function addImages($product_id)
    {
        return view('dashboard.products.image.create')->withId($product_id);
    }

    public function saveImages(Request $request)
    {
        $file = $request->file('dzfile');
        $fileName = uploadPhoto('products', $file);
        return response()->json([
            'name' => $fileName,
            'original_name' => $file->getClientOriginalName()
        ]);
        return 0;
    }

    public function saveImagesDb(Request $request)
    {
        if ( count($request->document) > 0) {
            foreach ($request->document as $image) {
                Image::create([
                    'product_id' => $request->product_id,
                    'photo' => $image
                ]);
            }
            return \redirect()->route('products.index')->with(['success' => 'm3alem']);
        }
        
    }
}
