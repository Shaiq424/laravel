<?php

namespace App\Http\Services;

use Illuminate\Foundation\Http\FormRequest;

class faq
{
    /**
     * To show All FAQS
     *
     * @return bool
     */
      
    public function show()  
    {  
        echo "show ALL";
    }  

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
