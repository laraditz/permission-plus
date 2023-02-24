<?php

namespace Laraditz\PermissionPlus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'methods' => 'required|array',
            'uri' => 'required|string',
            'route_name' => 'nullable|string',
            'action_name' => 'required|string',
            'allow_all' => 'required|boolean',
            'allow_guest' => 'required|boolean',
            'roles' => 'nullable|array',
        ];
    }
}
