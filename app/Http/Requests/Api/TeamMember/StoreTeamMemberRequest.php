<?php

namespace App\Http\Requests\Api\TeamMember;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamMemberRequest extends FormRequest
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
            'full_name' => 'required',
            'position_id' => 'required|exists:player_positions,id',
            'power' => 'required|integer|min:0|max:100',
        ];
    }
}
