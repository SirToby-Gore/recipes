<?php

require_once __DIR__ . '/_classes.php';


class Token {
    public function __construct(
        public string $token,
        public string $user_id,
        public string $created_on,
    ) {}

    public static function from_id(string $token): self {
        $result = get_data_from_id('Tokens', $token, 'token');

        if (!$result) {
            throw new Exception("Token not found: $token");
        }

        return new self(
            $result['token'],
            $result['user_id'],
            $result['created_on']
        );
    }

    public function create(): void {
        if (empty($this->token) || empty($this->user_id)) {
            throw new Exception("Token object missing required properties (token, user_id, created_on) for creation.");
        }
        if (self::is_id_in_use($this->token)) {
            throw new Exception("Cannot create token. Token '{$this->token}' is already in use.");
        }
        if (!User::is_id_in_use($this->user_id)) {
            throw new Exception("Cannot create token. User ID '{$this->user_id}' is invalid.");
        }

        global $connection;

        $stmt = $connection->prepare("INSERT INTO `Tokens` (`token`, `user_id`) VALUES (?, ?)");
        $stmt->bind_param('ss', $this->token, $this->user_id);
        $stmt->execute();
        $stmt->close();

        $this->created_on = Token::from_id($this->token)->created_on;
    }


    public static function is_token_in_use(string $token): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `token` FROM `Tokens` WHERE `token`=?");
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }

    public static function is_id_in_use(string $id): bool {
        global $connection;

        $stmt = $connection->prepare("SELECT `token` FROM `Tokens` WHERE `user_id`=?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $count = $stmt->get_result()->num_rows;
        $stmt->close();
        return $count > 0;
    }
    
    public static function get_new_token(): string {
        global $connection;

        while (true) {
            $id = random_string(length: 200);
            
            $stmt = $connection->prepare("SELECT `token` FROM `Tokens` WHERE `token`=?");
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            
            if ($result->num_rows === 0) {
                return $id;
            }
        }
    }

    public static function clear_old_tokens(): void {
        global $connection;

        $stmt = $connection->prepare("DELETE FROM `Tokens` WHERE `created_on` < DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $stmt->execute();
    }

    static public function get_blank(): self {
        return new self(
            '',
            '',
            ''
        );
    }

    public function delete(): void {
        global $connection;

        $stmt = $connection->prepare("DELETE FROM `Tokens` WHERE `token`=?");
        $stmt->bind_param('s', $this->token);
        $stmt->execute();
    }
}
