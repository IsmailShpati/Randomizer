<?php

class Register extends Controller
{
    protected User $user;

    private const PASSWORD_REGEX = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';

    private static function dbg($msg) {
        error_log("RegisterController_SMAJLI --> " . $msg);
    }

    public function index()
    {
        unset($_SESSION['errMsg']);
        $this->view("register");
    }

    public function register() {
        unset($_SESSION['errMsg']);
        self::dbg("Inside register with POST request " . print_r($_POST));


            if(!$this->validateRegisterRequest()){
                self::dbg('Inside validation error.');
                $this->view('login');
            } else {
                self::dbg('Inside user creation');
                $this->createNewUser();
            }

    }

    private function validateRegisterRequest(): bool
    {
        // Clear old errors
        unset($_SESSION['errMsg']);

        // Validate if user exists, user name must be unique
        $userNameCheck = User::where('user_name', $_POST['userName'])->first();
        self::dbg('Fetched users from database with username: ' . $_POST['userName'] . " => " . $userNameCheck);

        if($userNameCheck != null) {
            $_SESSION['errMsg'] = 'Username already exists.';
            return false;
        }


        if(!preg_match(self::PASSWORD_REGEX, $_POST['userPassword'])) {
            $_SESSION['errMsg'] = 'Please enter a valid password that contains at least one character(upper/lower), one digit and one special character.';
            return false;
        }

        return true;

    }

    private function createNewUser()
    {
        // Generate unique id with session id as prefix to avoid 0.001% possibility of generation on the same microsecond
        $userId = uniqid(session_id());
        self::dbg('Generated userId: ' . $userId);
        try{

            $newUser = User::create([
                'user_id' => $userId,
                'user_name' => $_POST['userName'],
                'user_password' => password_hash($_POST['userPassword'], PASSWORD_BCRYPT)]);

            self::dbg('New user: ' . $newUser);
            unset($_SESSION['errMsg']);
            $this->view('login');

        }catch(Exception $e) {
            $_SESSION['errMsg'] = 'Oopsiee, something bad happened, please try again.';
            self::dbg('Inside exception on createNewUser: ' . $e);
        }


    }

}
