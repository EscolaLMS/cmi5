<?php

namespace EscolaLms\Cmi5\Http\Requests;

use EscolaLms\Cmi5\Models\Cmi5;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class Cmi5ReadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('read', Cmi5::class);
    }

    public function rules(): array
    {
        return [];
    }
}
