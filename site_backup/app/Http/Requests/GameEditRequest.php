<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameEditRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255|unique:games,subdomain,' . $this->game->id,
            'order' => 'required|integer|min:1',
            'max_players_per_team' => 'required|integer|min:1',
            'max_teams_per_player' => 'required|integer|min:1',
            'max_teams_per_player_premium' => 'required|integer|min:1',
            'bo_list' => 'required|string|max:255',
            'vs_list' => 'required|string|max:255',
            'classic_modes_list' => 'required|string|max:255',
            'logo' => 'image|mimes:jpeg,jpg,png',
            'menu_logo' => 'image|mimes:jpeg,jpg,png',
            'logo_list_trainings' => 'image|mimes:jpeg,jpg,png',
            'banner' => 'image|mimes:jpeg,jpg,png',
            'network' => 'required|integer|exists:networks,id',
            'platform' => 'required|integer|exists:platforms,id',
            'time_per_round' => 'required|integer|min:1',
            'rules' => 'required|string',
        ];
    }
}
