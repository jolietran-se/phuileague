<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentRequest extends FormRequest
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
            'name' => 'bail|required|unique:tournaments|max:255',
            'tournament_type_id' => 'bail|required',

            'number_club' => 'bail|required|numeric',
            'number_player' => 'bail|required|numeric',
            'number_group' => 'bail|required_if:tournament_type_id,03',
            'number_knockout' => 'bail|required_if:tournament_type_id,03',

            'number_round' => 'bail|required_unless:tournament_type_id,01',
            'score_win' => 'bail|required_unless:tournament_type_id,01',
            'score_draw' => 'bail|required_unless:tournament_type_id,01',
            'score_lose' => 'bail|required_unless:tournament_type_id,01',
            'register_date'=> 'bail|required_if:register_permission, on',
            'charter' => 'mimes:doc,docx,pdf'
        ];
    }
}
