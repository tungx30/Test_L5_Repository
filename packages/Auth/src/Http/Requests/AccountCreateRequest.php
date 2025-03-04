<?php

namespace Packages\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:accounts,email',
            'password'  => 'required|string|min:8|confirmed',
            'account_type' => 'required|string|max:50',
            'account_id'   => 'nullable|uuid',
        ];
    }
    public function messages()
    {
        return [
            'name.required'     => 'Tên không được để trống.',
            'email.required'    => 'Email không được để trống.',
            'email.email'       => 'Email không hợp lệ.',
            'email.unique'      => 'Email đã tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min'      => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed'=> 'Mật khẩu xác nhận không khớp.',
            'account_type.required' => 'Loại tài khoản không được để trống.',
            'account_id.uuid'       => 'ID tài khoản không hợp lệ.',
        ];
    }
}
