<?php
/*******************************************************************************
 * Le sujet est assez basique :
 *
 * - Page de connexion
 * - Lors d'une connexion réussie, la date de dernière connexion est mise à jour et
 * on est redirigé sur la page principale si le mot de passe dans la base
 * correspond au mot de passe entré et si l'utilisateur fait partie du groupe 2.
 * Si l'authentification échoue, on retourne sur la page de connexion et un message
 * d'erreur s'affiche.
 * - Une fois connecté, une phrase mal orthographiée est affichée. Cliquer dessus la
 * corrige.
 * - On peut ensuite se déconnecter, on est alors redirigé vers la page de connexion.
 *
 * Tu es libre de faire le test à ta manière le but étant de nous montrer ce que tu sais faire
 *
 * Informations de connexion à la DB
 *
 * Host : localhost
 * Login : fidyranaivos_6m4E8
 * Password : gqNOIbU2BUVx
 * Db name : fidyranaivos_6m4E8
 *******************************************************************************/

ini_set('display_errors', 0);
include_once('./Repository/UserMysqlDatabase.php');
include_once('./Model/User.php');
include_once('./Service/Authentication.php');

session_start();

$params = [
    'errors' => $_SESSION['connexion_error'] ?? 'errors'
];

if (isset($_GET['action']) && $_GET['action'] === 'login') {
    $username = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $connection = new UserMysqlDatabase();
    $authentication = new Authentication($connection);
    $authentication->login($username, $password);
}

if (isset($_GET['action']) && $_GET['action'] === 'logout'){
    $connection = new UserMysqlDatabase();
    $authentication = new Authentication($connection);
    $authentication->logout();
    session_destroy();
}

if (isset($_SESSION['id_user'])) {
    echo str_replace(array_keys($params), $params, file_get_contents('main.html'));
} else {
    echo match ($_GET['action'] ?? '') {
        'login' => '',
        'logout' => '',
        default => str_replace(array_keys($params), $params, file_get_contents('login.html')),
    };
}
