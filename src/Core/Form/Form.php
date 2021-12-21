<?php

declare(strict_types=1);

namespace App\Core\Form;

use App\Core\BaseModel;

class Form
{
    public static function begin(string $action, string $method): self
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);

        return new static();
    }

    public static function end()
    {
        return '</form>';
    }

    public function field(BaseModel $model, string $attribute, string $classes = ''): Field
    {
        return new Field($model, $attribute, $classes);
    }
}
