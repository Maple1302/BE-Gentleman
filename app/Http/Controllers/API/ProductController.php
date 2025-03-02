<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Services\ProductService;
use App\Traits\APIResponse;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
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
        $products = $this->productService->getAllProducts();
        return $this->responseSuccess(
            __('Lấy danh sách thành công!'),
            [
                'product' => $products,
            ]
        );
    }

    public function store(ProductsRequest $request)
    {
        $productData = $request->all();
        $variantsData = $request->input('variants', []);
        // Gọi phương thức lưu trữ sản phẩm và biến thể
        $product = $this->productService->createProductWithVariantsAndAttributes($productData, $variantsData);

        return $this->responseCreated(
            __('Tao san pham thanh cong!'),
            [
                'product' => $product
            ]
        );
    }


    public function show(int $id)
    {
        $product = $this->productService->showProduct($id);
        if (!$product) {
            return
                $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!')

                );
        } else {
            return $this->responseSuccess(
                __('lay san pham thanh cong!'),
                [
                    'product' => $product,
                ]
            );
        }
    }

    public function update(ProductsRequest $request, $id)
    {
        $data = $request->all();
        $product = $this->productService->updateProductWithVariantsAndAttributes($id, $data);
        if (!$product) {
            return $this->responseNotFound(
                Response::HTTP_NOT_FOUND,
                __('khong tim thay san pham !')
            );
        } else {
            $product->update($data);
            return $this->responseSuccess(
                __('sua thanh cong'),
                [
                    'product' => $product
                ]
            );
        }
    }

    public function updateSaleInProduct(Request $request, $id)
    {
        $data = $request->validate([
            'sale_id' => 'required',
        ]);
        $product = $this->productService->updateSaleInProduct($id, $data);
        if (!$product) {
            return $this->responseNotFound(
                Response::HTTP_NOT_FOUND,
                __('khong tim thay san pham !')
            );
        }
        // else {
        //     $product->update($data);
        //     return $this->responseSuccess(
        //         __('sua thanh cong'),
        //         [
        //             'product' => $product
        //         ]
        //     );
        // }
    }

    public function destroy(string $id)
    {
        $product = $this->productService->destroyProduct($id);
        if (!$product) {
            return $this->responseNotFound(
                Response::HTTP_NOT_FOUND,
                __('khong tim thay bien the!')
            );
        } else {
            return $this->responseDeleted(null, Response::HTTP_NO_CONTENT);
        }
    }

    public function getBySale()
    {
        try {
            $products = $this->productService->getAllWithSale();

            if ($products->isEmpty()) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!')
                );
            } else {
                return response()->json([
                    'data' => $products,
                    'message' => 'Successfully retrieved products with sale_id',
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->responseServerError(
                __('loi khi lay danh sach san pham theo sale_id: ') . $e->getMessage()
            );
        }
    }
    public function getBySaleId()
    {
        try {
            $products = $this->productService->getAllProductBySaleBigger1();

            if ($products->isEmpty()) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!')
                );
            } else {
                return response()->json([
                    'data' => $products,
                    'message' => 'Successfully retrieved products with sale_id',
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->responseServerError(
                __('loi khi lay danh sach san pham theo sale_id: ') . $e->getMessage()
            );
        }
    }
    public function getProductBySaleId($id)
    {
        try {
            $products = $this->productService->getProductBySaleId($id);

            if ($products->isEmpty()) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!')
                );
            } else {
                return response()->json([
                    'data' => $products,
                    'message' => 'Successfully retrieved products with sale_id',
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->responseServerError(
                __('loi khi lay danh sach san pham theo sale_id: ') . $e->getMessage()
            );
        }
    }

    public function getProductByName(Request $request)
    {
        try {
            $name = $request->input('name');
            $getProductByName = $this->productService->getProductsByName($name);
            if ($getProductByName->isEmpty()) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!')
                );
            } else {
                return response()->json([
                    'data' => $getProductByName,
                    'message' => 'Successfully retrieved products with name',
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->responseServerError(
                __('loi khi lay danh sach san pham theo ten: ') . $e->getMessage()
            );
        }
    }

    public function getProductByCategory(Request $request)
    {
        try {
            $name = $request->input('name');
            $getProductByCategory = $this->productService->getProductsByCategory($name);
            if ($getProductByCategory->isEmpty()) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('khong tim thay san pham!')
                );
            } else {
                return response()->json([
                    'data' => $getProductByCategory,
                    'message' => 'Successfully retrieved products with cate',
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->responseServerError(
                __('loi khi lay danh sach san pham theo cate: ') . $e->getMessage()
            );
        }
    }

    public function filter(Request $request)
    {
        try {
            $products = $this->productService->filter($request);
            if ($products->isEmpty()) {
                return $this->responseNotFound(
                    Response::HTTP_NOT_FOUND,
                    __('Khong tim thay san pham')
                );
            } else {
                return response()->json([
                    'data' => $products,
                    'message' => 'Loc san pham thanh cong'
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return $this->responseServerError(
                __('loi khi loc san pham: ') . $e->getMessage()
            );
        }
    }
}
