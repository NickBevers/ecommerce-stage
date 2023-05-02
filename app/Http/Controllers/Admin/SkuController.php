<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidationRequest;
use App\Http\Requests\SkuValidationRequest;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductImage;
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
use App\Services\VatService;
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
    private VatService $vatService;

    public function __construct()
    {
        $this->attributeValueService = new GetAttributeValuesService();
        $this->brandService = new GetBrandsService();
        $this->subCategoryService = new SubCategoryService();
        $this->productService = new ProductService();
        $this->skuService = new SkuService();
        $this->uploadSkuImageService = new UploadSkuImageService();
        $this->vatService = new VatService();
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
           'countries' => $this->vatService->getCountries(),
       ]);
    }

    public function store(ProductValidationRequest $request)
    {
        $productRequest = new ProductValidationRequest($request->only(['title', 'description', 'audience', 'brand_id', 'sub_category_id', 'product_type', 'extra_info']));
        $product = $this->productService->store($productRequest);

        foreach ($request->input('variations') as $variation) {
            $skuTemp = Sku::where('sku', $variation['sku'])->first();
            if ($skuTemp) {
                return $request->validate([
                    'variations.*.sku' => 'unique:skus,sku',
                ],
                [
                    'variations.*.sku.unique' => 'The sku has already been taken.',
                ]);
            }

            $vat = Vat::where('id', $request->input('vat_id'))->first();
            $sku = Sku::create([
                'sku' => $variation['sku'],
                'price_excl_vat' => $variation['price'],
                'price_incl_vat' => $variation['price'] * (1 + floatval($vat->vat_rate) / 100),
                'amount' => $variation['amount'],
                'product_id' => $product->id,
            ]);


            foreach ($variation['images'] as $image) {
                ProductImage::create([
                    'image_type' => explode('/', $image['public_id'])[0],
                    'image_link' => $image['url'],
                    'image_public_id' => $image['public_id'],
                    'sku_id' => $sku->id,
                    'alt' => $variation['sku'].'-'.$image['public_id'],
                ]);
            }

            // loop through the attributes and attach them to the sku
            foreach ($variation['attributes'] as $attribute) {
                $attributeValue = AttributeValue::where('name', $attribute)->first();
                $sku->attributeValues()->attach($attributeValue);
            }
        }

        return redirect()->route('admin.products.index');
    }

    public function toggleActive(Sku $sku)
    {
        $sku->is_active = !$sku->is_active;
        $sku->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Product status updated',
        ]);
    }

    public function uploadImages(Request $request)
    {
//        ray($request['files']);
        ray($request->index);
        $urls = $this->uploadSkuImageService->uploadVariationImage($request['files'], []);
        return response()->json([
            'urls' => $urls,
            'index' => $request['index'],
        ]);
    }

    public function deleteVariationImage(Request $request)
    {
        $this->uploadSkuImageService->deleteVariationImage($request->input('public_id'));
        ProductImage::where('image_public_id', $request->input('public_id'))->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Image deleted',
        ]);
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

            $attributeTypes = AttributeType::all();
            foreach ($attributeTypes as $attributeType) {
                $attributeType->attributeValues = $this->attributeValueService->getValuesByTypeId($attributeType->id);
            }

            $categories = Category::all();
            foreach ($categories as $category) {
                $category->subCategories = $this->subCategoryService->getSubCategoriesByCategory($category);
            }

        return Inertia::render('Admin/Products/Edit', [
            'skus' => $sku,
            'brands' => $this->brandService->getBrands(),
            'categories' => $categories,
            'attributeTypes' => $attributeTypes,
            'sizes' => $this->attributeValueService->getValuesByType("size"),
            'colors' => $this->attributeValueService->getValuesByType("color"),
            'materials' => $this->attributeValueService->getValuesByType("material"),
        ]);
    }

    public function update(SkuValidationRequest $request, Sku $sku)
    {
        if ($request->has('product')) {
            $product = $request->input('product');
            $productData = new ProductValidationRequest($product->only(['title', 'description', 'audience', 'brand_id', 'sub_category_id', 'product_type', 'extra_info']));
            $this->productService->update($productData, $sku->product_id);
        }

        if (sizeof($request->input('variations')['newImages']) > 0) {
            foreach ($request->input('variations')['newImages'] as $image) {
                ProductImage::create([
                    'image_type' => explode('/', $image['public_id'])[0],
                    'image_link' => $image['url'],
                    'image_public_id' => $image['public_id'],
                    'sku_id' => $sku->id,
                    'alt' => $sku->sku.'-'.$image['public_id'],
                ]);
            }
        }

        $sku->attributeValues()->detach();
        foreach ($request->input('variations')['attributes'] as $attribute) {
            $attributeValue = AttributeValue::where('name', $attribute)->first();
            $sku->attributeValues()->attach($attributeValue);
        }

        $vat = Vat::where('id', 27)->first();
        $sku->sku = $request->input('variations')['sku'];
        $sku->price_excl_vat = $request->input('variations')['price'];
        $sku->price_incl_vat = $request->input('variations')['price'] * (1 + floatval($vat->vat_rate) / 100);
        $sku->amount = $request->input('variations')['amount'];
        $sku->save();

        return Inertia::render('Admin/Products/Index', [
            'skus' => Sku::withAllRelations()
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'attributeValues' => AttributeValue::all(),
            'minPrice' => Sku::min('price_incl_vat'),
            'maxPrice' => Sku::max('price_incl_vat'),
        ]);
    }

    public function destroy(Sku $sku)
    {
        $sku->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}