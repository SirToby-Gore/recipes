<?php

require_once __DIR__ . '/_classes.php';

class Account {
    public function __construct(    
        public bool $logged_in,
        public User $user,
        public Token $token,
    ) {}
    
    public static function get_account(): self {
        if (!isset($_SESSION['token'])) {
            return self::get_blank();  
        }

        $users_token = $_SESSION['token'];

        if (!TOken::is_token_in_use($users_token)) {
            return self::get_blank();
        }
        
        $token = Token::from_id($users_token);
        
        if (!User::is_id_in_use($token->user_id)) {
            return self::get_blank();
        }
        
        $user = User::from_id($token->user_id);
        
        return new self(
            true,
            $user,
            $token
        );
    }

    static public function get_blank(): self {
        return new self(
            false,
            User::get_blank(),
            Token::get_blank(),
        );
    }
}