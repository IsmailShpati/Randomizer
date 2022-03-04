<?php


include_once(__DIR__.'/../utils/Constants.php');
class Login extends Controller
{
    protected User $user;

    private static function dbg($msg) {
        error_log("LoginController_SMAJLI --> " . $msg);
    }

    public function index()
    {
        //Changes url without reloading and trigger the router
        echo "<script>window.history.pushState(null, null, '".BASE_URL."/home')</script>";

        $this->view("login");
    }

    // Preferably using POST method when passing passwords around
    public function login() {
        unset($_SESSION['errMsg']);
        self::dbg("Inside login");
        $this->user = new User();
        $this->user->userName = $_POST['userName'];
        $this->user->userPassword = $_POST['userPassword'];

        if(!$this->validateUserAuth()) {
            self::dbg("Validate user auth failed.");
            $this->index();
        } else {
            self::dbg("User login successful, redirecting to home page.");
            $this->view("home");
        }
    }

    private function validateUserAuth(): bool
    {
        $userNameCheck = User::where('user_name', $this->user->userName)
                              ->first();
        self::dbg("Fetched user from database for user name: " . $this->user->userName  . " => " . $userNameCheck);

        if($this->isRecordEmpty($userNameCheck)) {
            $_SESSION['errMsg'] = 'Username does not exists. Please try with a valid username.';
            return false;
        }


        if(!password_verify($this->user->userPassword, $userNameCheck->user_password)) {
            $_SESSION['errMsg'] = 'Password does not match username.';
            return false;
        }

        unset($_SESSION['errMsg']);

        $_SESSION['isAuth'] = true;
        $_SESSION['userName'] = $userNameCheck->user_name;
        $_SESSION['userId'] = $userNameCheck->user_id;
        return true;
    }

    private function isRecordEmpty($dbRecord): bool
    {
        if($dbRecord == null) {
            return true;
        }
        return false;
    }


}
