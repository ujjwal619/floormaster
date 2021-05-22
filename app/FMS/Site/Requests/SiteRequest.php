<?php

namespace App\FMS\Site\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // $siteId = request()->segment(2) ?? '0';
        return [
            
        ];
    }
}
