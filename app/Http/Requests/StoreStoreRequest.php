<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'district' => 'required|numeric',
            'address' => 'required|max:256',
            'storekeepers.*' => 'exists:users,id',
            'excelItems' => 'nullable|mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
    }

    public function messages()
    {
        return [
            'district.required' => 'Kerület kötelező',
            'address.required' => 'Cím kötelező',
            'storekeepers.exists' => 'Felhasználó nem létezik',
            'excelItems.mimetypes' => 'Rossz fájltípus. Elfogadott kiterjesztések: xls, xlsx'
        ];
    }
}
