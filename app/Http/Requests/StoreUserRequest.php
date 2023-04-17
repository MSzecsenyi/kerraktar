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
            'name' => 'required',
            'group_number' => 'required',
            'district' => 'required|numeric',
            'is_group' => 'required_without_all:is_storekeeper,is_admin|boolean',
            'is_storekeeper' => 'required_without_all:is_group,is_admin|boolean',
            'is_admin' => 'required_without_all:is_group,is_storekeeper|boolean',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Ez az email már használatban van más felhasználónál',
            // 'name.unique' => 'Ez a név már használatban van más felhasználónál',
            // 'group_number.unique' => 'Csapatonként egy felhasználó hozható létre '
        ];
    }
}
