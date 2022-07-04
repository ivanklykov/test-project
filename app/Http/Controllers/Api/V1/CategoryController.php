<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category as CategoryModel;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoryRequest;
use Illuminate\Http\{Response,JsonResponse};

class CategoryController extends Controller
{
    protected CategoryModel $categoryModel;

    public function __construct(
        CategoryModel $categoryModel
    ) {
        $this->categoryModel = $categoryModel;
    }

    /**
     * @api {post} /api/v1/category/:id Create category
     * @apiVersion 1.0.0
     * @apiName CreateCategory
     * @apiGroup Category
     *
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = $this->categoryModel->create($request->validated());

        return (new CategoryResource($category))
            ->additional(['message' => trans('notifications.store.success')])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /api/v1/category/:id Delete category
     * @apiVersion 1.0.0
     * @apiName DeleteCategory
     * @apiGroup Category
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $category = $this->categoryModel->findOrFail($id);

        if ($category->products()->exists()) {
            return response()
                ->json(['message'=> 'Invalid input data', 'errors' => ['name' => trans('Category contains products')]])
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->delete();

        return response()
            ->json(['message' => trans('notifications.destroy.success'),])
            ->setStatusCode(Response::HTTP_OK);
    }
}
