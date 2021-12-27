<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\BaseModel;
use App\Core\Request;

class User extends BaseModel
{
    private string $table = 'users';

    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirm = '';

    public static function fromRequest(Request $request): User
    {
        $input = $request->getBody();

        return self::fromArray([
            'firstName' => $input['firstName'],
            'lastName' => $input['lastName'],
            'email' => $input['email'],
            'password' => $input['password'],
            'passwordConfirm' => $input['passwordConfirm'],
        ]);
    }

    public function rules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE,
                'class' => self::class,
                'field' => 'email',
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '8']],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    protected function getTableName(): string
    {
        return $this->table;
    }


    protected function getAttributes(): array
    {
        return [
            'first_name',
            'last_name',
            'email',
            'password_hash',
        ];
    }

    protected function getAttributesMap(): array
    {
        return [
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'email' => 'email',
            'password_hash' => 'password',
        ];
    }

    public function getMappedAttributeValue(string $mappedKey): mixed
    {
        return $this->{$this->getAttributesMap()[$mappedKey]};
    }

    public function save(): mixed
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
    }
}
