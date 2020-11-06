<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'max:255',
        ];
    }

    /**
     * Get the project form route model binding
     *
     * @return App\Models\Project
     */
    public function project()
    {
        return Project::findOrFail($this->route('project'));
    }

    /**
     * Update the project
     * 
     * @return App\Models\Project
     */
    public function save()
    {
        return tap($this->project())->update($this->validated());
    }
}
