<div class="container">
    <div class="row">
        <div class="col-sm text-center mt-4">
            <?php if (isset($_SESSION['logged'])) { ?>
            <h2>Hello, <?php echo $_SESSION['user_name']; ?></h2>
            <?php } else { ?>
            <h2>Users</h2>
            <?php } ?>
            <p><?php echo $random; ?></p>
        </div>
    </div>
</div>
