<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AssignTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('tickets.assign');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'agent_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->has('agent_id')) {
                    return;
                }

                $agent = User::find($this->integer('agent_id'));

                if (! $agent?->is_active || ! $agent->hasRole('agent')) {
                    $validator->errors()->add(
                        'agent_id',
                        'El usuario seleccionado no es un agente activo.'
                    );
                }
            },
        ];
    }
}
