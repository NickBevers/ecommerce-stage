<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sku;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Products', [
            'skus' => Sku::with('attributeValues')
                ->with('product')
                ->orderBy('sku')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
        ]);

    }

    public function create()
    {
        return Inertia::render('products/create');
    }

    public function testFunction()
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
            'category' => 'required|string|max:255',
            'extra_info' => 'required|string|max:500',
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
        $product->category_id = $categoryId;
        $product->extra_info = $request->extra_info;

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

    public function getStatus(Product $product)
    {
        return $product->is_active;
    }

    public function setStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        return $product->is_active;
    }

    public function getPromotionStatus(Product $product)
    {
        return $product->is_promotion;
    }

    public function setPromotionStatus(Product $product)
    {
        $product->is_promotion = !$product->is_promotion;
        $product->save();
        return $product->is_promotion;
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
        $productToUpdate->update($request->all());
    }
