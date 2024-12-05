<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\HandleImagesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\This;


class ProductService
{

    use HandleImagesTrait;
    private $limit = 10;


    /**
     * @param $request
     * @return mixed
     */

    public function getWithPaginate(): mixed
    {
        return Product::query()->latest('rate')->paginate(10);
    }

    public function store($request): mixed
    {
        $dataCreate = $request->all();

        $classifies = $request->classifies ? json_decode($request->classifies) : [];
        $dataCreate['img_preview'] = $this->saveImage($request, 'img_preview');
        $dataCreate['images'] =  $this->saveImages($request, 'images');
        $product = Product::create($dataCreate);
        $this->updateDetail($product, $dataCreate, $classifies);

        return $product;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id): bool
    {
        try {
            $product = $this->findOrFail($id)->load(['images']);
            $dataUpdate = $request->all();

            // Xử lý ảnh cũ và ảnh mới
            $oldImages = $request->data_images ? json_decode($request->data_images) : [];
            $classifies = $request->classifies ? json_decode($request->classifies) : [];

            foreach ($oldImages as $image) {
                if (!$product->images->contains('id', $image)) {
                    $this->deleteImage($image->url);
                }
            }
         
            $dataUpdate['img_preview'] =  $this->updateImage($request, 'img_preview', $product->img_preview);
       
            $dataUpdate['images'] =  $this->saveImages($request, 'images');
          
            $urlArray = array_map(function ($image) {
                return $image->url;
            }, $oldImages);

            $product->update($dataUpdate);
            $product->images()->delete();
   
            $product->syncImages($urlArray);
    
            $product->details()->delete();
            $this->updateDetail($product, $dataUpdate, $classifies);

            return true;
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi
            Log::error($e->getMessage());
            return false;
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        $product = $this->findOrFail($id);
        $product->delete();
        $product->deleteImage();
        $this->deleteImage($product?->images?->first()?->url);

        return $product;
    }

    public function findOrFail($id): mixed
    {
        $product = Product::findOrFail($id);
        return $product;
    }


    public function updateDetail(Product $product, mixed $dataCreate, $classifies): Product|null
    {

        $product->syncImages($dataCreate['images'] ?? []);

        $product->assignCategory($dataCreate['category_ids'] ?? []);
      
        if($classifies!=null){
            $proDetails = [];
            foreach ($classifies as $classify) {
                $proDetails[] = ['color' => $classify->color, 'quantity' => $classify->quantity, 'product_id' => $product->id];
            }
            $product->details()->insert($proDetails);
        }

        return $product;
    }


    public function searchProducts($name)
    {
        return Product::where('name', 'like', '%' . $name . '%')->paginate(10);
    }
    
}
