<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="<?php echo URL; ?>css/bootstrap.min.css" rel="stylesheet">
    <title>Users</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL; ?>">Users</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['logged'])) { ?>
                <li class="nav-item mr-2">
                    <a href="<?php echo URL . 'user/delete/' . htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8'); ?>" class="nav-link btn btn-danger my-2 my-sm-0">Delete</a>
                </li>
                <li class="nav-item mr-2">
                    <a href="<?php echo URL . 'user/edit/' . htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8'); ?>" class="nav-link btn btn-info my-2 my-sm-0">Edit</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo URL . 'user/logout'; ?>" class="nav-link btn btn-outline-default">Logout</a>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a href="<?php echo URL . 'user/login'; ?>" class="nav-link btn btn-outline-default">Login</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo URL . 'user/register'; ?>" class="nav-link btn btn-outline-default">Register</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
