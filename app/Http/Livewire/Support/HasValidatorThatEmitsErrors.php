<?php


namespace App\Http\Livewire\Support;


use Illuminate\Validation\ValidationException;
use Livewire\Component;

/** @mixin Component */
trait HasValidatorThatEmitsErrors
{
    public function validateAndEmitErrors($rules = null, $messages = [], $attributes = []): array
    {
        try {
            return $this->validate($rules, $messages, $attributes);
        } catch (ValidationException $validationException) {
            throw $this->emitValidationExceptionErrors($validationException);
        }
    }

    public function emitValidationExceptionErrors(ValidationException $exception): ValidationException
    {
        $this->emit("validation-errors", $exception->errors());
        return $exception;
    }

    public function emitClearErrors()
    {
        $this->emit("validation-errors", []);
    }
}