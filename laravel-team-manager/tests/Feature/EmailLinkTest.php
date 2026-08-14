<?php

use App\View\Components\EmailLink;

test('email link component renders the correct blade view', function () {
    $email = 'hello@example.com';
    $component = new EmailLink($email);

    $view = $component->render();

    expect($view->name())->toBe('components.email-link');
});

test('email link component sets email property', function () {
    $email = 'hello@example.com';
    $component = new EmailLink($email);

    expect($component->email)->toBe($email);
});