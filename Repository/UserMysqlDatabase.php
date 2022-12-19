<?php

include_once 'UserDatabaseInterface.php';

class UserMysqlDatabase implements UserDatabaseInterface
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=fidyranaivos_6m4E8;charset=utf8', 'fidyranaivos_6m4E8', 'gqNOIbU2BUVx');
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function findOneByUsernameAndPasswordAndGroup(string $username, string $password, string $groupName): User
    {
        $sql = "SELECT u.* FROM user u
                INNER JOIN user_group ug ON u.id_user = ug.id_user
                INNER JOIN `group` g ON g.id_group = ug.id_group
                WHERE u.username = '" . htmlspecialchars($username) . "'
                AND u.password = '" . htmlspecialchars($password) . "'
                AND g.name = '" . $groupName . "'
                LIMIT 1";

        $req = $this->db->query($sql);
        $res = $req->fetch();
        $id = $res['id_user'] ?? null;
        $username = $res['username'] ?? '';
        $password = $res['password'] ?? '';
        $lastLogin = isset($res['last_login']) ? date_create($res['last_login']) : null;
        return new User($id, $username, $password, $lastLogin);
    }

    public function updateUserLastLogin(User $user): void
    {
        $sql = 'UPDATE user 
                     SET last_login = \''. $user->getLastLogin()->format('Y-m-d h:i:s') . '\'
                     WHERE id_user = '. $user->getId();

        $this->db->query($sql);
    }
}