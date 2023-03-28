<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Http\Controllers\SubCategoryController;
use App\Models\AttributeValue;
use App\Models\Sku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'skus' => Sku::withAllRelations()
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price'),
            'maxPrice' => Sku::max('price'),
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        return Sku::whereHas('product', function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%');
            })
            ->withAllRelations()
            ->orderBy('sku')
            ->paginate(10);
    }

    public function create()
    {
        $attributeTypes = app(AttributeTypesController::class)->getAllTypes();
        foreach ($attributeTypes as $attributeType) {
            $attributeType->attributeValues = app(AttributeValueController::class)->getValuesByType($attributeType->id);
        }

        $categories = app(CategoryController::class)->getAllCategories();
        foreach ($categories as $category) {
            $category->subCategories = app(SubCategoryController::class)->getSubCategoriesById($category->id);
        }
       return Inertia::render('Admin/Products/Create', [
           'brands' => app(BrandController::class)->getAllBrands(),
           'categories' => $categories,
           'attributeTypes' => $attributeTypes,
       ]);
    }

    public function store(Request $request)
    {
        $productData = $request->only(['title', 'description', 'audience', 'brand_id', 'sub_category_id', 'product_type', 'extra_info']);
        $product = app(ProductController::class)->store(new Request($productData));

        foreach ($request->input('variations') as $variation) {
            $sku = Sku::create([
                'sku' => $variation['sku'],
                'price' => $variation['price'],
                'amount' => $variation['amount'],
                'product_id' => $product->id,
            ]);

            foreach ($variation['images'] as $image) {
                $type = 'image';
                $isThumbnail = false;
                if ($variation['images'][0] == $image) {
                    $type = ('thumbnail');
                    $isThumbnail = true;
                }
                $cloudinaryData = app(CloudinaryController::class)->uploadImage($image, $isThumbnail);
                app(ProductImageController::class)->store($sku->id, $cloudinaryData['secure_url'], $cloudinaryData['public_id'], "productImage", $type);
            }

            $color = AttributeValue::where('name', $variation['color'])->first();
            $sku->attributeValues()->attach($color);

            $material = AttributeValue::where('name', $variation['material'])->first();
            $sku->attributeValues()->attach($material);

            foreach ($variation['sizes'] as $size) {
                $size = AttributeValue::where('name', $size)->first();
                $sku->attributeValues()->attach($size);
            }
        }

//        return $product;
        return redirect()->route('admin.products.index');
    }

    public function sortClothing(Array $data): array
    {
//        $sizes = [ 'One Size', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL', '6XL', '7XL', '8XL', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '52', '54', '56', '58', '60', '62', '64', '66', '68', '70', '90', '94', '98', '102','106', '110',];
        $sizes = app(AttributeValueController::class)->getValuesByType("size");
        $res = array_intersect($sizes, $data);
        return array_values($res);
    }

    public function edit(String $skuNumber)
    {
        $sku = Sku::where('sku', $skuNumber)
            ->withAllRelations()
            ->first();

        return Inertia::render('Admin/Products/Edit', [
            'skus' => $sku,
            'brands' => app(BrandController::class)->getAllBrands(),
            'categories' => app(CategoryController::class)->getAllCategories(),
            'attributeTypes' => app(AttributeTypesController::class)->getAllTypes(),
            'sizes' => app(AttributeValueController::class)->getValuesByType("size"),
            'colors' => app(AttributeValueController::class)->getValuesByType("color"),
            'materials' => app(AttributeValueController::class)->getValuesByType("material"),
        ]);
    }

    public function update(Request $request, Sku $sku)
    {
        $productData = $request->only(['title', 'description', 'audience', 'brand_id', 'sub_category_id', 'product_type', 'extra_info']);
        $product = app(ProductController::class)->update(new Request($productData), $sku->product_id);

        $images = $request->files;
        foreach ($images as $image) {
            $type = 'image';
            $isThumbnail = false;
            if ($images[0] == $image) {
                $type = ('thumbnail');
                $isThumbnail = true;
            }
            $cloudinaryData = app(CloudinaryController::class)->uploadImage($image->getRealPath(), $isThumbnail);
            app(ProductImageController::class)->store($product->id, $cloudinaryData['secure_url'], $cloudinaryData['public_id'], $image->getClientOriginalName(), $type);
        }

        $sku->update([
            'sku' => $request->input('sku'),
            'price' => $request->input('price'),
            'amount' => $request->input('amount'),
        ]);

        $sku->attributeValues()->detach();
        $color = AttributeValue::where('name', $request->input('color'))->first();
        $sku->attributeValues()->attach($color);

        $material = AttributeValue::where('name', $request->input('material'))->first();
        $sku->attributeValues()->attach($material);

        $sizes = $this->sortClothing($request->input('sizes'));
        foreach ($sizes as $size) {
            $size = AttributeValue::where('name', $size)->first();
            $sku->attributeValues()->attach($size);
        }

        return redirect()->route('admin.products.index');
    }

    public function destroy(Sku $sku)
    {
        $sku->delete();
        return redirect()->route('admin.products.index');
    }
}