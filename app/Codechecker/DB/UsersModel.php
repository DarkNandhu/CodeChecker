<?php
namespace Codechecker\DB;

class UsersModel extends dbconfig{

private static $columns = ['id', 'name', 'email', 'password', 'mobile', 'token', 'credit'];
    public function __construct(){
        parent::__construct();
    }
    public function getUserByToken($token){
        $placeholder = [];
        $sql = 'SELECT * FROM users WHERE token = :token';
        $placeholder[':token'] = $token;
        return $this->select($sql, $placeholder);
    }
}