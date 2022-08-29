<?php
class loginController extends Controller {

    public function index() {
        $data = [
            'msg' => ''
        ];

        if(!empty($_POST['number'])) {
            $unumber = $_POST['number'];
            $upass = $_POST['password'];

            $user = new Users();
            if($user->verifyUser($unumber, $upass)){
                $token = $user->createToken($unumber);
                $_SESSION['token'] = $token;
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $data['msg'] = 'Número e/ou senha inválidos';
            }

            
        }

        $this->loadView('login', $data);
    }

}

