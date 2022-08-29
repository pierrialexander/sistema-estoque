<?php

/**
 * Classe do Model de Usuários
 */
class Users extends Model {

    private $info;

    /**
     * Método que faz a busca e verificação da existencia do usuário na base de dados.
     * @param $number
     * @param $pass
     * @return bool
     */
    public function verifyUser($number, $pass) {
        $sql = "SELECT * FROM users WHERE user_number = :unumber AND user_pass = :upass";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':unumber', $number);
        $sql->bindValue(':upass', md5($pass));
        $sql->execute();


        if($sql->rowCount() > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Método responsável por criar o token e salvar na base de dados.
     * @param $unumber
     * @return string
     */
    public function createToken($unumber) {
        $token = md5(time() . rand(0,9999) . time() . rand(0,9999) . 'token');
        $sql = "UPDATE users SET user_token = :token WHERE user_number = :number";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':token', $token);
        $sql->bindValue(':number', $unumber);
        $sql->execute();

        return $token;
    }

    public function checkLogin() {
        // checa se o usuario possui um token na sessão
        if(!empty($_SESSION['token'])) {
            $sql = "SELECT * FROM users WHERE user_token = :token";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':token', $_SESSION['token']);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $this->info = $sql->fetch();
                return true;
            }
        }
        return false;
    }
}
