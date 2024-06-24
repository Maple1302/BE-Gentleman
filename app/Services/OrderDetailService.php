<?php

namespace App\Services;

use App\Models\OrderDetail;
use App\Models\Variant;
use Attribute;

class OrderDetailService extends AbstractServices
{
    public function __construct(Variant $cart)
    {
        parent::__construct($cart);
    }

    public function getAllOrderDetail()
    {
        return $this->eloquentGetAll();
    }

    public function storeOrderDetail($data)
    {
        return $this->eloquentMutiInsert($data);
    }

    public function showOrderDetail($id)
    {
        return $this->eloquentFind($id);
    }

    public function updateOrderDetail($id, $data)
    {
        return $this->eloquentUpdate($id, $data);
    }

    public function destroyOrderDetail($id)
    {
        return $this->eloquentDelete($id);
    }

    public function eloquentVariantConvertData($param)
    {
        $data = [];
        foreach ($param['data'] as $key => $value) {
            // L?y th�ng tin c?a variant c�ng v?i c�c m?i quan h? li�n quan
            $variant = $this->eloquentWithRelations($value['variant_id'], ['attributeValues.attribute']);
            $data[] = [
                'variant_id' => $variant->id,
                'product_id' => $variant->product_id,
                'price' => $variant->price,
                'price_promotional' => $variant->price_promotional,
                'quantity' => $variant->quantity,
                'atribute' =>
                    $variant->attributeValues->map(function ($attributeValue) {
                        return [
                            'name' => $attributeValue->attribute->name,
                            'value' => $attributeValue->value
                        ];
                    })

            ];
        }

        return $data;
    }

    public function eloquentOrderDetailWithVariant($param)
    {
        $variant = $this->eloquentVariantConvertData($param);

        return $variant;
    }
}
