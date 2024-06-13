<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\BillDetailRequest;
use App\Traits\APIResponse;
use Illuminate\Http\Response;
use App\Services\BillDetailService;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;

class BillDetailController extends BillDetailService
{
    use APIResponse;
    protected $billDetailService;
    function __construct(BillDetailService $billDetailService)
    {
        $this->billDetailService = $billDetailService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->billDetailService->getAllBillDetail();
        return $this->responseCreated(__
        ('tao danh muc thanh cong'),
        [
            'data' => $data,
        ]);
    }

    public function store(BillDetailRequest $request)
    {
        $request = $request->all();
        $data = $this->billDetailService->storeBillDetail($request);
        return $this->responseCreated(__
        ('tao danh muc thanh cong'),
        [
            'status' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $data = $this->billDetailService->showBillDetail($id);
       if (!$data) {
        return $this->responseNotFound(
            Response::HTTP_NOT_FOUND,
            __('khong tim thay danh muc'));
        }else{
        return $this->responseSuccess(
            __('hien thi danh muc thanh cong'),
          [
              'data' => $data,
          ]
        );
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
}
