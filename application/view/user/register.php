<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <h2 class="text-center mt-4 mb-4">Register</h2>
            <?php if ($this->error) { ?>
                <?php foreach ($this->error as $error) { ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                <?php } ?>
            <?php } ?>
            <form action="<?php echo URL . 'user/register'; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" class="form-control" id="input-name">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" class="form-control" id="input-email">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control" id="input-password">
                </div>
                <button type="submit" name="user_register" class="btn btn-info btn-block mb-2">Create account</button>
            </form>
        </div>
    </div>
</div>
