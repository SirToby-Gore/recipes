<?php

require_once __DIR__ . '/init.php';
class RegexExps {
    public static string $email = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,}$/i";
    
    public static string $name = "/^([ \x{00c0}-\x{01ff}a-zA-Z'\-])+$/u";
}

class Blank {
    public static User $user;
}

Blank::$user = new User('', '', '', '', '', '');