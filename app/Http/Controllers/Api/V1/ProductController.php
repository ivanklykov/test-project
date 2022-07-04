<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\{Product as ProductModel, Category};
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Response;
use App\Http\Requests\Api\V1\ProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\Filter\FilterPool as ProductFilterPool;

class ProductController extends Controller
{
    public function __construct(
       protected ProductModel $productModel,
       protected ProductFilterPool $productFilterPool
    ) {

    }

    /**
     * @api {get} /api/v1/product Get Product List
     * @apiVersion 1.0.0
     * @apiName GetProducts
     * @apiGroup Product
     *
     * @apiParam {int} [page=1]
     * @apiParam {int} [per_page=15]
     * @apiParam {decimal} price_from
     * @apiParam {decimal} price_to
     * @apiParam {string} name
     * @apiParam {boolean} status
     * @apiParam {boolean} is_archive
     *
     * @apiExample Query example:
     *     /api/v1/product?per_page=1&page=3
     */
    public function index(Request $request): JsonResponse
    {
        $productsBuilder = $this->productFilterPool->applyFilters($this->productModel, $request);
        $products = $productsBuilder->with('categories')->paginate($request->per_page);

        return (new ProductResource($products))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }


    /**
     * @api {post} /api/v1/product Create Product
     * @apiVersion 1.0.0
     * @apiName PostProducts
     * @apiGroup Product
     *
     * @apiParam {string} name Product name
     * @apiParam {decimal} price Product price
     * @apiParam {boolean} status Status(enable/disable)
     * @apiParam {boolean} is_archive Is archive product(enable/disable)
     * @apiParam {int[]} categories Product categories(enable/disable)
     *
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productModel->create($request->validated());
        $product->categories()->attach(
            Category::find($request->categories)
        );

        return (new ProductResource($product))
            ->additional(['message' => trans('notifications.store.success')])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    /**
     * @api {get} /api/v1/product Get Product by id
     * @apiVersion 1.0.0
     * @apiName GetProduct
     * @apiGroup Product
     *
     * @apiParam {int} $id Product id
     *
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->productModel->with('categories')->findOrFail($id);

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @api {put} /api/v1/product Update Product
     * @apiVersion 1.0.0
     * @apiName UpdateProducts
     * @apiGroup Product
     *
     * @apiParam {string} name Product name
     * @apiParam {decimal} price Product price
     * @apiParam {boolean} status Status(enable/disable)
     * @apiParam {boolean} is_archive Is archive product(enable/disable)
     *
     */
    public function update(ProductRequest $request, $id): JsonResponse
    {
        $product = $this->productModel->findOrFail($id);
        $product->update($request->validated());

        return (new ProductResource($product))
            ->additional(['message' => trans('notifications.update.success')])
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /api/v1/product/:id Delete product
     * @apiVersion 1.0.0
     * @apiName DeleteProduct
     * @apiGroup Product
     */
    public function destroy(int $id): JsonResponse
    {
        $this->productModel->findOrFail($id)->delete();

        return response()
            ->json(['message' => trans('notifications.destroy.success')])
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @api {patch} /api/v1/product/:id/archive Archive product
     * @apiVersion 1.0.0
     * @apiName ArchiveProduct
     * @apiGroup Product
     */
    public function archive(int $id): JsonResponse
    {
        $product = $this->productModel->findOrFail($id);
        $product->is_archive = true;
        $product->save();

        return response()
            ->json(['message' => trans('notifications.archive.success')])
            ->setStatusCode(Response::HTTP_OK);
    }
}
