<?php

class User extends Controller
{
    public $error = [];

    /**
     * ACTION: register
     * This method handles user account creation
     */
    public function register()
    {
        if (isset($_POST['user_register']) && $this->validate()) {
            // check is email in database
            $user = $this->model->getUser($_POST['email']);

            if ($user) {
                $this->error['user'] = 'User exists';
            }

            if (!$this->error) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $hash = md5(mt_rand(0, 1000));

                $this->model->addUser($_POST['name'], $_POST['email'], $password, $hash);

                $this->sendMail($_POST['name'], $_POST['email'], $_POST['password'], $hash);

                header('location: ' . URL . 'user/confirm');
            }

        }

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/register.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * ACTION: login
     * This method handles user sign in
     */
    public function login()
    {
        if (isset($_POST['user_login']) && $this->validateLogin()) {
            $user = $this->model->getUser($_POST['email']);

            if ($user) {
                if ((password_verify($_POST['password'], $user->password)) && !empty($user->active)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_name'] = $user->name;
                    $_SESSION['user_email'] = $user->email;
                    $_SESSION['logged'] = 1;

                    header('location: ' . URL . 'home/index');
                }
            } else {
                $this->error['error'] = 'Wrong email or password.';
            }
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/user/login.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * ACTION: logout
     * This method handles user logout
     */
    public function logout()
    {
        // Clear session data
        $_SESSION = [];
        // Remove SID cookie
        unset($_COOKIE[session_name()]);
        // Destroy session storate
        session_destroy();

        header('location: ' . URL . 'home/index');
    }

    /**
     * ACTION: edit
     * This method handles what happens when you move to http://yourproject/user/edit
     */
    public function edit()
    {
        // check is user logged in
        if (isset($_SESSION['logged'])) {
            // check is POST request and validate data
            if (isset($_POST['user_edit']) && $this->validate()) {
                // get user data
                $user = $this->model->getUser($_POST['email']);

                if ($user) {
                    // generate an error if email address is exists
                    // and not belogs to the current user
                    if ($user->id !== $_SESSION['user_id']) {
                        $this->error['email'] = 'Email already in use.';
                    }
                }

                if (!$this->error) {
                    // update user name and email
                    $this->model->editUser($_SESSION['user_id'], $_POST['name'], $_POST['email']);

                    // update session user name
                    $_SESSION['user_name'] = $_POST['name'];
                    $_SESSION['user_email'] = $_POST['email'];

                    // update password if password field does not empty
                    if (!empty($_POST['password'])) {
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $this->model->updatePassword($_SESSION['user_id'], $password);
                    }

                    header('location: ' . URL . 'home/index');
                }
            }

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/user/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'home/index');
        }
    }

    /**
     *  ACTION: delete
     * This method handles what happens when you move to http://yourproject/user/delete
     * @param int $user_id Id of the to-delete user
     */
    public function delete($user_id)
    {
        // if we have an id of a user that should be deleted
        if (isset($user_id)) {
            // do deleteUser() in model/model.php
            $this->model->deleteUser($user_id);
        }

        // logout session
        $this->logout();

        // where to go after user has been deleted
        header('location: ' . URL . 'home/index');
    }

    /**
     *  ACTION: confirm
     * This method handles user account confirmation page
     */
    public function confirm()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/confirm.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     *  ACTION: activate
     * This method handles user account activation
     */
    public function activate()
    {
        $user = $this->model->getUser($_GET['email']);

        if ($user) {
            if (($_GET['code'] === $user->hash) && empty($user->active)) {
                $this->model->activateUser($user->id);

                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['logged'] = 1;

                header('location: ' . URL . 'home/index');
            }
        } else {
            header('location: ' . URL . 'problem/index');
        }

    }

    /**
     *  ACTION: validate
     * This method handles input data validation for user name, email and password fields
     */
    public function validate()
    {
        if ((strlen($_POST['name']) < 3) || (strlen($_POST['name'] > 64))) {
            $this->error['name'] = 'Name error';
        }

        if (!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) {
            $this->error['email'] = 'Email error';
        }

        if (!isset($_SESSION['logged'])) {
            if ((strlen($_POST['password']) < 3) || (strlen($_POST['password'] > 64))) {
                $this->error['password'] = 'Password error';
            }
        }

        return !$this->error;

    }

    /**
     *  ACTION: validateUser
     * This method handles user data validation on login
     */
    public function validateLogin()
    {
        if (!filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) {
            $this->error['email'] = 'Email error';
        }

        if ((strlen($_POST['password']) < 3) || (strlen($_POST['password'] > 64))) {
            $this->error['password'] = 'Password error';
        }

        return !$this->error;
    }

    /**
     * ACTION: sendMail
     * This method handles sending verification code to email
     */
    public function sendMail($name, $email, $password, $code)
    {
        $to = $email;
        $subject = 'Email Verification';
        $message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

-------------------------
Username: ' . $name . '
Password: ' . $password . '
-------------------------

Please click this link to activate your account:
http:' . URL . 'user/activate/?email=' . $email . '&code=' . $code . '

        ';
        // set FROM headers
        $headers = 'From:noreply@example.com' . "\r\n";
        // send
        mail($to, $subject, $message, $headers);
    }
}
