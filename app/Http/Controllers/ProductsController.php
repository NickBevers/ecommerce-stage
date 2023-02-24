<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
//        return Inertia::render('products/index', [
//            'products' => $products
//        ]);
        return $products;
    }

    public function create()
    {
        return Inertia::render('products/create');
    }

    public function addOne()
    {
        return "Works";
    }

    public function store(Request $request)
    {

        // validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'audience' => 'required|string|max:255',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'extra_info' => 'required|string|max:500',
            'sku' => 'required|string|max:255',
            'product_number' => 'required',
//            'files' => 'array|required',
//            'files.*' => 'required|mimetypes:image/jpg,image/jpeg,image/bmp'
        ]);

        $imageArray = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $randomName = now().rand(1,500);
                $filename = $randomName.$image->getClientOriginalName();
                Storage::move($filename, 'public/images/' . $filename);
                $imageArray[] = $filename;
            }
        }

        $categoryId = SubCategory::where('label', $request->category)->first()->id;

        // create a new product
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->audience = $request->audience;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $categoryId;
        $product->extra_info = $request->extra_info;
        $product->sku = $request->sku;
        $product->product_number = $request->product_number;

        $request->has('is_promotion') ? $product->is_promotion = true :  $product->is_promotion = false;
        $request->has('is_active') ? $product->is_active = false : $product->is_active = true;

        $product->images = json_encode($imageArray);
        $product->save();
        $productId = $product->id;


        if ($request->hasFile('images')){
            foreach ($imageArray as $image) {
                ProductImagesController::store($image, $productId);
            }
        }

//        return redirect()->route('products.index');
        return $product;
    }

    public function show(Product $product)
    {
        return Inertia::render('products/show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product)
    {
        $productDetails = Product::find($product->id);

        return Inertia::render('products/edit', [
            'product' => $productDetails
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $productToUpdate = Product::find($product->id);
        $productToUpdate->insert($request->all());
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }
}