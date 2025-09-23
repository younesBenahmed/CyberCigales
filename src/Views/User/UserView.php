<?php

namespace Views\User;
use Models\User\User;
use Views\AbstractView;

class UserView extends AbstractView {
    public const USERNAME_KEY = 'USERNAME_KEY';
    public const EMAIL_KEY = 'EMAIL_KEY';
    private const TEMPLATE_HTML = __DIR__ . '/user.html';

    public function __construct(private User $user){
    }

    public function templatePath() : string {
        return self::TEMPLATE_HTML; 
    }

    public function templateKeys() : array {
        return [self::USERNAME_KEY => $this->user->getUsername(), self::EMAIL_KEY => $this->user->getEmail()] ;
    }
}