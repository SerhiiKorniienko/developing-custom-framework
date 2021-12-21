<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;

class ContactController extends BaseController
{
    public function view(): string
    {
        $params = [
            'name' => 'contacts',
        ];

        return $this->render('contact', $params);
    }

    public function store(Request $request): string
    {
        $body = $request->getBody();

        return 'storing submitted form data';
    }
}
