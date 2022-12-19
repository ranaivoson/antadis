<?php

class Authentication
{
    public function __construct(private UserDatabaseInterface $database)
    {
    }

    public function login($username, $password){
        /** @var User $user */
        $user = $this->database->findOneByUsernameAndPasswordAndGroup($username, $password, 'groupe 2');
        if ($user->getId()){
            $this->onAuthenticationSuccess($user);
        }else{
            $this->onAuthenticationFailure();
        }
        header('location: index.php');
        exit;
    }

    public function logout(){
        session_destroy();
        header('location: index.php');
        exit;
    }

    private function onAuthenticationSuccess(User $user): void
    {
        $user->setLastLogin(new DateTime());
        $this->database->updateUserLastLogin($user);
        $_SESSION['id_user'] = $user->getId();

    }

    private function onAuthenticationFailure(): void
    {
        $_SESSION['connexion_error'] = 'Identifiants Invalides';
    }
}