<?php

namespace App\Http\Requests\Feature;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|max:255|unique:products,name",
            "code" => "required|string|max:255|unique:products,code",
            "product_category_id" => "nullable|integer|exists:product_categories,id",
            "brand_id" => "nullable|integer|exists:brands,id",
            "price" => "required|numeric",
            "stock_alert" => "required|numeric",
            "note" => "nullable|string|max:255",
            "warehouse_id" => "required|integer|exists:warehouses,id",
            "vendor_id" => "nullable|integer|exists:vendors,id",
            "quantity" => "required|integer",
            "status" => "required|string",
            "image.*" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ];
    }
}
