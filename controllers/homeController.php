<?php
class homeController extends Controller {

    private $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        // verifica se existe algum token na sessão e se é válido
        if(!$this->user->checkLogin()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public function index() {
        $data = array();
        $this->loadTemplate('home', $data);
    }

}