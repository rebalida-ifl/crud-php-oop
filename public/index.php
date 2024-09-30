<?php

require '../vendor/autoload.php';

use App\database;
use App\user;

$database = new database();
$db = $database->connect();
$user = new user($db);

$action = $_GET['action'] ?? '';
$message = '';

switch ($action){
    case 'create':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST['name'];
            $email = $_POST['email'];   
            if ($user->create($name, $email)){
                $message = "User created successfully!";
            }else{
                $message = "Error creating user.";
            }
        }
        break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                if ($user->update($id, $name, $email)) {
                    $message = "User updated successfully!";
                    header("Location: index.php");
                exit();
                } else {
                    $message = "Error updating user.";
                }
            }
            break;
    
        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['id'];
                if ($user->delete($id)) {
                    $message = "User deleted successfully!";
                    header("Location: index.php");
                exit();
                } else {
                    $message = "Error deleting user.";
                }
            }
            break;
}

$users = $user->readAll();

?>

<!doctype html>
<html lang="en">
    <head>
        <title>CRUD</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <div class="container">
            <h2 class="text-center">Users</h2>
            <a href="add-new.php" class="btn btn-dark mb-3 text-start">Add New</a>
            <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $usr): ?>
                    <tr>
                        <td><?php echo $usr['id'] ?></td>
                        <td><?php echo $usr['name'] ?></td>
                        <td><?php echo $usr['email'] ?></td>
                        <td>
                            <!-- Update Form -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-pen-to-square fs-"></i>
                            </button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="?action=update" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $usr['id']; ?>">
                                        <input type="text" name="name" value="<?php echo $usr['name']; ?>" required>
                                        <input type="email" name="email" value="<?php echo $usr['email']; ?>" required>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Form -->
                            <form action="?action=delete" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $usr['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa-solid fa-trash fs-5"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
            </div>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
