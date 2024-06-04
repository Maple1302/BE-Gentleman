<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Services\ProductService;
use App\Traits\APIResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use APIResponse;

    protected $productService;


    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $product = $this->productService->getAllProducts();
        return $this->responseSuccess(
            __('Lấy danh sách thành công!'),
            [
                'data' => $product,
            ]
        );
    }

    public function store(ProductsRequest $request)
    {
        $data = $request->all();
        $product = $this->productService->createProduct($data);
        return $this->responseCreated(
            __('Tao san pham thanh cong!'),
            [
                'data' => $product
            ]
        );
    }

    public function show(String $id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product) {
            return
                $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!'),
                    [
                        'data' => $product,
                    ]
                );
        } else {
            return $this->responseSuccess(
                __('lay san pham thanh cong!'),
                [
                    'data' => $product,
                ]
            );
        }
    }

    public function update(ProductsRequest $request, $id)
    {
        $data = $request->all();
        $product = $this->productService->updateProduct($id, $data);
        if (!$product) {
            return $this->responseNotFound(
                Response::HTTP_NOT_FOUND,
                __('khong tim thay san pham !'),
                [
                    'data' => $product
                ]
            );
        } else {
            $product->update($data);
            return $this->responseSuccess(
                __('sua thanh cong'),
                [
                    'data' => $product
                ]
            );
        }
    }

    public function destroy(string $id)
    {
        $product = $this->productService->deleteProduct($id);
        if (!$product) {
            return $this->responseNotFound(
                Response::HTTP_NOT_FOUND,
                __('khong tim thay bien the!')
            );
        } else {
            $product->delete();
            return $this->responseDeleted(null, Response::HTTP_NO_CONTENT);
        }
    }
}
