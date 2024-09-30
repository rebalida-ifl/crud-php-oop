<?php

require '../vendor/autoload.php';

use App\database;
use App\user;

$database = new database();
$db = $database->connect();
$user = new user($db);

$action = $_GET['action'] ?? '';

switch ($action){
    case 'create':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST['name'];
            $email = $_POST['email'];
            if ($user->create($name, $email)){
                echo "User created successfully!";
            }else{
                echo "Error creating user.";
            }
        }
        break;

    case 'read':
        $users = $user->readAll();
        foreach($users as $usr){
            echo "{$usr['id']}: {$usr['name']} ({$usr['email']})<br>";
        }
        break;

  case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            if ($user->update($id, $name, $email)) {
                echo "User updated successfully!";
            } else {
                echo "Error updating user.";
            }
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($user->delete($id)) {
                echo "User deleted successfully!";
            } else {
                echo "Error deleting user.";
            }
        }
        break;

    default:
        echo "Welcome to the PHP CRUD Application!";
        break;

}

