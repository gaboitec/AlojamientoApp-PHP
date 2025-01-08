<?php
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $created;

    private $table_name = "users";

    public function __construct(private $connection) {}

    public function login($email, $password)
    {
        $this->email = $email;
        $this->password = $password;

        $query = "SELECT * FROM {$this->table_name} 
            WHERE email={$this->email} AND password={$this->password}";
        $sentence = $this->connection->prepare($query);
        $sentence->execute();
        return $sentence;
    }
}
