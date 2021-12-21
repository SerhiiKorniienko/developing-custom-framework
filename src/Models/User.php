<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\BaseModel;
use App\Core\Request;

class UserModel extends BaseModel
{
    private string $table = 'users';

    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirm = '';

    protected function getTableName(): string
    {
        return $this->table;
    }

    public static function fromRequest(Request $request): UserModel
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
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '8']],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }
}
