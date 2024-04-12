<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubdomainRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
               'subdomain' => 'required',
                    'name' => 'required',
                     'url' => 'required|url',
                 'db_host' => 'required',
                 'db_port' => 'required|integer',
                 'db_name' => 'required',
                 'db_user' => 'required',
             'db_password' => 'required',
                'state_id' => 'required',
            'access_control_system' => 'required',
            'notification' => 'required',
               'is_mirror' => 'required',
                     'sso' => 'required',
        ];
    }
    
    public function messages(){
        return [
               'subdomain.required' => __('required'),
                    'name.required' => __('required'),
                     'url.required' => __('required'),
                          'url.url' => __('url'),
                 'db_host.required' => __('required'),
                 'db_port.required' => __('required'),
                  'db_port.integer' => __('integer'),
                 'db_name.required' => __('required'),
                 'db_user.required' => __('required'),
             'db_password.required' => __('required'),
                'state_id.required' => __('required'),
            'access_control_system.required' => __('required'),
            'notification.required' => __('required'),
               'is_mirror.required' => __('required'),
                     'sso.required' => __('required'),
        ];
    }
}
