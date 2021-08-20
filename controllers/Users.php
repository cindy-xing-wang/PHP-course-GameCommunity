<?php
class Users extends Controller {
    private ISession $_session;
    public function __construct(ISession $session) {
        $this->userModel = $this->model('User');
        $this->_session = $session;
    }

    public function register() {
      $data = [
          'username' => '',
          'email' => '',
          'password' => '',
          'confirmPassword' => '',
          'username_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
      ];

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Process form
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

              $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['password2']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            //Validate username on letters/numbers
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username.';
            } elseif (!preg_match($nameValidation, $data['username'])) {
                $data['username_err'] = 'Name can only contain letters and numbers.';
            }

            //Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email address.';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter the correct format.';
            } else {
                //Check if email exists.
                if ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken.';
                }
            }

           // Validate password on length, numeric values,
            if(empty($data['password'])){
              $data['password_err'] = 'Please enter password.';
            } elseif(strlen($data['password']) < 6){
              $data['password_err'] = 'Password must be at least 8 characters';
            }

            //Validate confirm password
             if (empty($data['confirmPassword'])) {
                $data['confirm_password_err'] = 'Please enter password.';
            } else {
                if ($data['password'] != $data['confirmPassword']) {
                $data['confirm_password_err'] = 'Passwords do not match, please try again.';
                }
            }

            // Make sure that errors are empty
            if (empty($data['usernameError']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register user from model function
                if ($this->userModel->register($data)) {
                    //Redirect to the login page
                    header('location: require.php');
                } else {
                    die('Something went wrong.');
                }
            }
        }
        $this->view('register', $data);
    }

    public function login() {
        $data = [
            'email' => '',
            'password' => '',
            'emailOrPass_err' => ''
        ];

        //Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'emailOrPass_err' => ''
            ];
            //Validate username
            if (empty($data['email']) || empty($data['password']) ) {
                $data['emailOrPass_err'] = 'Please enter a email and password.';
            }

            //Check if all errors are empty
            if (empty($data['usernameError']) && empty($data['passwordError'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                  echo "login user";
                    $this->createUserSession($data['email']);
                } else {
                    $data['emailOrPass_err'] = 'Password or username is incorrect. Please try again.';
                    echo "wrong";
                    $this->view('login', $data);
                }
            }

        } else {
            $data = [
                'email' => '',
                'password' => '',
                'emailOrPass_err' => ''
            ];
            $this->view('login', $data);
        }
        $this->view('login', $data);
    }

    public function createUserSession($email) {
         $this->_session->set('email', $email);
         $this->_session->set('start', time());

         // Ending a session in 60 minutes from the starting time.
         $this->_session->get('expire');
         $value = $this->_session->get('start');
         $this->_session->set('expire', $value + (60*60) );
     }

     public function logout() {
         // session_destroy();
         $this->_session->clear();
         header('location:require.php');
     }

}
