<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class UpdateBookLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['required'],
            'end_date' => ['required'],
            'user_id' => ['required'],
            'book_id' => ['required'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $totalDay = getNumberOfDays($this->start_date, $this->end_date);
                if ( $totalDay < 1 ) {
                    $validator->errors()->add( 'end_date', 'tanggal pengembalian tidak boleh sama dengan tanggal pinjam' );
                } elseif (Carbon::parse($this->start_date)->isAfter($this->end_date)) {
                    $validator->errors()->add( 'end_date', 'tanggal pengembalian tidak boleh kurang dari tanggal pinjam' );
                }
            }
        ];
    }
}
