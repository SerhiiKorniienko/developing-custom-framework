<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\BaseModel;

class Field
{
    public const TYPE_TEXT = 'text';

    public const TYPE_PASSWORD = 'password';

    public const TYPE_EMAIL = 'email';

    public const TYPE_NUMBER = 'number';

    private BaseModel $model;

    private string $attribute;

    private string $classes;

    private string $type;

    public function __construct(BaseModel $model, string $attribute, $classes)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->classes = $classes;
        $this->type = self::TYPE_TEXT;
    }

    public function password(): self
    {
        $this->type = self::TYPE_PASSWORD;

        return $this;
    }

    public function email(): self
    {
        $this->type = self::TYPE_EMAIL;

        return $this;
    }

    public function numeric(): self
    {
        $this->type = self::TYPE_NUMBER;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                <input type="%s" name="%s" value="%s" class="form-control%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->classes . $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->getFirstError($this->attribute),
        );
    }
}