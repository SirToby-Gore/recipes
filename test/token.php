<?php

require_once '_classes.php';

class Token
{
    public function __construct(
        public string $token,
        public string $user_id,
        public string $created_on,
    ) {}

    public function create(): bool
    {
        global $conn;
        $stmt = $conn->prepare('INSERT INTO `Tokens` (`token`, `user_id`, `created_on`) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $this->token, $this->user_id, $this->created_on);
        return $stmt->execute();
    }

}
