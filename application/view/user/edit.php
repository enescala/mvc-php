<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <h2 class="text-center mt-4 mb-4">Edit user information</h2>
            <?php if ($this->error) { ?>
                <?php foreach ($this->error as $error) { ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                <?php } ?>
            <?php } ?>
            <form action="<?php echo URL . 'user/edit'; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Name" class="form-control" id="input-name">
                </div>
                <div class="form-group">
                <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Email Address" class="form-control" id="input-email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control" id="input-password">
                </div>
                <button type="submit" name="user_edit" class="btn btn-info btn-block mb-2">Update</button>
            </form>
        </div>
    </div>
</div>
