<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MaxValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать не больше :max символов';

    public function __construct(string $fieldName, $value, $args = [], string $message = null)
    {
        parent::__construct($fieldName, $value, $args, $message);
        $this->messageKeys[':max'] = $this->args[0] ?? '';
    }

    public function rule(): bool
    {
        return mb_strlen((string)$this->value) <= (int)($this->args[0] ?? 0);
    }
}