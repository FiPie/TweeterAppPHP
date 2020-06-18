<?php
include_once 'config.php';

$isLogged = isLogged();
$isAdmin = isAdmin();

$brand = $isLogged ? ("<a class='navbar-brand' href='user_dashboard.php'>" . $_SESSION["userName"] . "</a>") : '<a class="navbar-brand" href="index.php">Home</a>';

$current_page = filter_input(INPUT_POST, "page");
$current_page = (!isset($current_page) || $current_page < 0) ? 0 : $current_page;
$search = filter_input(INPUT_POST, "search");
$search = isset($search) ? $search : "";
$page_size = PAGE_SIZE;

$resultsArray = getSearchResult($search, $current_page, $page_size);
if (count($resultsArray) == 0 && $current_page > 0) {
        $current_page--;
        $resultsArray = getSearchResult($search, $current_page, $page_size);
}
?>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Fontawesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/style.css">
<script src="js/script.js"></script>
<!DOCTYPE html>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <?= $brand ?>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link disabled" href="<?= $activeHref ?>"><span><?= $activePageIcon ?></span></a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="index.php"><i class="fas fa-home"></i> Take me home</a>
                    <?php if ($isLogged && !$isAdmin): ?>
                        <a class="dropdown-item" href="message_add.php"><i class="far fa-comments"></i> New message</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <?php if (!$isLogged): ?>
                        <a class="dropdown-item" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <?php endif; ?> 
                    <?php if ($isLogged): ?>    
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <?php endif; ?>
                    <?php if (!$isLogged): ?>
                        <a class="dropdown-item" href="register.php"><i class="fas fa-user-plus"></i> Sign up</a>
                    <?php endif; ?>
                    <?php if ($isLogged): ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="user_dashboard.php"><i class="fas fa-user-circle"></i> My account</a>
                    <?php endif; ?>
                    <?php if ($isLogged && $isAdmin): ?>
                        <a class="dropdown-item" href="admin_dashboard.php"><i class="fas fa-users-cog"></i> Admin Tools</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="POST" action="index.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</nav>