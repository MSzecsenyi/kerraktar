<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|unique:users,name',
            'group_number' => 'required|unique:users,group_number',
            'district' => 'required',
            'group-checkbox-list' => 'required_without_all:storekeeper-checkbox-list,admin-checkbox-list|boolean',
            'storekeeper-checkbox-list' => 'required_without_all:group-checkbox-list,admin-checkbox-list|boolean',
            'admin-checkbox-list' => 'required_without_all:group-checkbox-list,storekeeper-checkbox-list|boolean',
        ];
    }
}
