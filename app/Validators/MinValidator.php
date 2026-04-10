<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class MinValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать не меньше :min символов';

    public function __construct(string $fieldName, $value, $args = [], string $message = null)
    {
        parent::__construct($fieldName, $value, $args, $message);
        $this->messageKeys[':min'] = $this->args[0] ?? '';
    }

    public function rule(): bool
    {
        return mb_strlen((string)$this->value) >= (int)($this->args[0] ?? 0);
    }
}