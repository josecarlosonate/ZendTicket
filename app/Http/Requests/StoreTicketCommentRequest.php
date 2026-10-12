<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTicketCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ticket = $this->route('ticket');
        $user = $this->user();

        return $user->can('comments.create')
            && $user->can('view', $ticket);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['required', 'string', 'max:5000'],
            'is_internal' => ['sometimes', 'boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (
                    $this->boolean('is_internal')
                    && ! $this->user()->can('comments.create_internal')
                ) {
                    $validator->errors()->add(
                        'is_internal',
                        'No tienes permiso para crear notas internas.'
                    );
                }
            },
        ];
    }
}
