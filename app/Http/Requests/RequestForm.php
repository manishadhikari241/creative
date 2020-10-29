<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestForm extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => 'required|max:30',
                        'title' => 'required|unique:forms,title|max:50',
                        'content' => 'required',
                        'color' => 'required'
                    ];
                }
            case 'PATCH':
            case 'PUT':
                {
                    return [
                        'name' => 'required|max:30',
                        'title' => 'required|max:50|unique:forms,title,' . $this->route()->parameter('test'),
                        'content' => 'required',
                        'color' => 'required'
                    ];
                }
            default:
                break;
        }

    }
}
