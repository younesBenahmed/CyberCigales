<?php

namespace Views;
use Models\User\User;
use Views\AbstractView;

class HomepageView extends AbstractView {
    private const KEYS = [];
    private const TEMPLATE_HTML = __DIR__ . '/homepage.html';

    public function templatePath() : string {
        return self::TEMPLATE_HTML;
    }

    public function templateKeys() : array {
        return self::KEYS;
    }
}