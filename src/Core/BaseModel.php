<?php

declare(strict_types=1);

namespace App\Core;

abstract class BaseModel
{
    public const RULE_REQUIRED = 'required';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_EMAIL = 'email';
    public const RULE_UNIQUE = 'unique';
    public const RULE_MATCH = 'match';

    public array $errors = [];

    public static function fromRequest(Request $request): self
    {
        $params = $request->getBody();

        return self::fromArray($params);
    }

    public static function fromArray(...$params): self
    {
        $model = new static();
        $params = count($params) === 1 ? $params[0] : $params;

        foreach ($params as $key => $value) {
            if (property_exists($model, $key)) {
                $model->{$key} = $value;
            }
        }

        return $model;
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attr => $rules) {
            $value = $this->{$attr};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (! is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && ! $value) {
                    $this->addError($attr, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL && ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attr, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attr, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attr, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attr, self::RULE_MATCH, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    abstract public function rules(): array;

    private function addError(string $attr, string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attr][] = $message;
    }

    private function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_UNIQUE => 'This field must be unique',
            self::RULE_MATCH => 'This field must be the same as {match}',
        ];
    }

    public function hasError(string $attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    public function getFirstError(string $attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }
}