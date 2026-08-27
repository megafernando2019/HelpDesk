<?php

namespace Modules\Tickets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Información General
            'title'        => ['required', 'string', 'max:255'],
            'ticket_type_id' => ['required', 'exists:tickets_types,id'],
            'category'  => ['required', 'exists:tickets_categories,id'],
            'ticket_service_id'   => ['required', 'exists:tickets_services,id'],
            'ticket_priority_id'  => ['required', 'exists:tickets_priorities,id'],
            'description'  => ['required'],

            // Información Adicional
            'url'           => ['nullable', 'url', 'max:255'],
            'attachments'   => ['nullable'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'], 
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required'          => 'El título del ticket es obligatorio.',
            'title.max'               => 'El título no debe sobrepasar los 255 caracteres.',
            'ticket_type_id.required' => 'Debes seleccionar un tipo de ticket.',
            'ticket_type_id.exists'   => 'El tipo de ticket seleccionado no es válido.',
            'category.required'       => 'Debes seleccionar una categoría.',
            'category.exists'         => 'La categoría seleccionada no es válida.',
            'ticket_service_id.required'  => 'Debes seleccionar un servicio.',
            'ticket_service_id.exists'    => 'El servicio seleccionado no es válido.',
            'ticket_priority_id.required' => 'Debes seleccionar una prioridad.',
            'ticket_priority_id.exists'   => 'La prioridad seleccionada no es válida.',
            'description.required'    => 'La descripción es obligatoria.',
            'url.url'                 => 'Ingresa una URL válida.',
            'url.max'                 => 'La URL no debe sobrepasar los 255 caracteres.',
            'attachments.*.mimes'     => 'Los archivos deben ser de tipo PDF, JPG, PNG o JPEG.',
            'attachments.*.max'       => 'Cada archivo no debe pesar más de 2 MB.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
