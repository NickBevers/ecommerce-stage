<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidationRequest;
use App\Http\Requests\SkuValidationRequest;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Sku;
use App\Models\Vat;
use App\Services\CloudinaryService;
use App\Services\GetAttributeValuesService;
use App\Services\GetBrandsService;
use App\Services\ProductImageService;
use App\Services\ProductService;
use App\Services\SkuService;
use App\Services\SubCategoryService;
use App\Services\UploadSkuImageService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SkuController extends Controller
{
    private GetAttributeValuesService $attributeValueService;
    private GetBrandsService $brandService;
    private SubCategoryService $subCategoryService;
    private ProductService $productService;
    private SkuService $skuService;
    private UploadSkuImageService $uploadSkuImageService;

    public function __construct()
    {
        $this->attributeValueService = new GetAttributeValuesService();
        $this->brandService = new GetBrandsService();
        $this->subCategoryService = new SubCategoryService();
        $this->productService = new ProductService();
        $this->skuService = new SkuService();
        $this->uploadSkuImageService = new UploadSkuImageService();
    }


    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'skus' => Sku::withAllRelations()
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price_incl_vat'),
            'maxPrice' => Sku::max('price_incl_vat'),
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
        $attributeTypes = AttributeType::all();
        foreach ($attributeTypes as $attributeType) {
            $attributeType->attributeValues = $this->attributeValueService->getValuesByTypeId($attributeType->id);
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            $category->subCategories = $this->subCategoryService->getSubCategoriesByCategory($category);
        }

       return Inertia::render('Admin/Products/Create', [
           'brands' => $this->brandService->getBrands(),
           'categories' => $categories,
           'attributeTypes' => $attributeTypes,
       ]);
    }

    public function store(ProductValidationRequest $request)
    {
        $productRequest = new ProductValidationRequest($request->only(['title', 'description', 'audience', 'brand_id', 'sub_category_id', 'product_type', 'extra_info']));
        $product = $this->productService->store($productRequest);

        foreach ($request->input('variations') as $variation) {
            $vat = Vat::where('id', $request->input('vat_id'))->first();
            $sku = Sku::create([
                'sku' => $variation['sku'],
                'price_excl_vat' => $variation['price'],
                'price_incl_vat' => $variation['price'] * (1 + $vat->vat_percentage / 100),
                'amount' => $variation['amount'],
                'product_id' => $product->id,
            ]);

            $this->uploadSkuImageService->upload($variation['images'], $sku->id);

            $color = AttributeValue::where('name', $variation['color'])->first();
            $material = AttributeValue::where('name', $variation['material'])->first();

            $this->skuService->attachAttributes($sku, $color, $material, $variation['sizes']);
        }

        return redirect()->route('admin.products.index');
    }

    public function sortClothing(Array $data): array
    {
//        $sizes = [ 'One Size', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL', '4XL', '5XL', '6XL', '7XL', '8XL', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '52', '54', '56', '58', '60', '62', '64', '66', '68', '70', '90', '94', '98', '102','106', '110',];
        $sizes = $this->attributeValueService->getValuesByType("size");
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
            'brands' => $this->brandService->getBrands(),
            'categories' => Category::all(),
            'attributeTypes' => AttributeType::all(),
            'sizes' => $this->attributeValueService->getValuesByType("size"),
            'colors' => $this->attributeValueService->getValuesByType("color"),
            'materials' => $this->attributeValueService->getValuesByType("material"),
        ]);
    }

    public function update(SkuValidationRequest $request, Sku $sku)
    {
        $productData = new ProductValidationRequest($request->only(['title', 'description', 'audience', 'brand_id', 'sub_category_id', 'product_type', 'extra_info']));
        $product = $this->productService->update($productData, $sku->product_id);

        $sku->productImages()->delete();
        $this->uploadSkuImageService->upload($request->input('images'), $sku->id);

        $vat = Vat::where('id', $request->input('vat_id'))->first();
        $sku->update([ 'sku' => $request->input('sku'), 'price_excl_vat' => $request->input('price'), 'price_incl_vat' => $request->input('price') * (1 + $vat->vat_percentage / 100) , 'amount' => $request->input('amount')]);

        $sku->attributeValues()->detach();
        $color = AttributeValue::where('name', $request->input('color'))->first();
        $material = AttributeValue::where('name', $request->input('material'))->first();
        $sizes = $this->sortClothing($request->input('sizes'));

        $this->skuService->attachAttributes($sku, $color, $material, $sizes);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Sku $sku)
    {
        Sku::destroy($sku->id);
        return redirect()->route('admin.products.index');
    }
}