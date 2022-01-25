<?php

namespace App\Http\Requests;

use App\Rules\WorkingDaysRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveSettingsRequest extends FormRequest
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
        return [
            'working_days'       => ['array', 'size:7', new WorkingDaysRule()],
            'working_hours.from' => 'date_format:H:i',
            'working_hours.to'   => 'date_format:H:i',
            'non_working_hours.from' => 'date_format:H:i',
            'non_working_hours.to'   => 'date_format:H:i'
        ];
    }
}
