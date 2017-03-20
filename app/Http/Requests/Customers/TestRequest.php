<?php

namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class TestRequest extends Request
{
    public function __construct()
    {
//         parent::__construct();
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'key'                  => 'required',
            
            'email'                => 'email|numeric',
            'name'                 => 'max:255',
            'age'                  => 'numeric|digits_between:1,3',
            'price'                => 'numeric|digits_between:1,10',
            'birth_day'            => 'date',
            'image'                => 'image|mimes:jpg,jpeg,gif,png|max:10000',
            'select'               => 'max:255|numeric|max:4',// SelectBoxは数値を取得
            'text'                 => 'max:255',
            'url'                  => 'url',// active_url : 有効なURL判定のはずだが、動作不良だった...
//             'start_date'           => "after:{$yesterday}|before:end_date",
            'end_date'             => 'after:start_date',
        ];
    }

    public function attributes()
    {
        return [
                //
        ];
    }

    public function messages()
    {
        return [
                //
        ];
    }

}
