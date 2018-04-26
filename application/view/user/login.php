<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4 mt-4">
            <h2 class="text-center">Login</h2>
            <br />
            <?php if ($this->error) { ?>
                <?php foreach ($this->error as $error) { ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                <?php } ?>
            <?php } ?>
            <form action="<?php echo URL . 'user/login'; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" class="form-control" id="input-email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control" id="input-password">
                </div>
                <button type="submit" name="user_login" class="btn btn-info btn-block mb-2">Login</button>
            </form>
        </div>
    </div>
</div>
