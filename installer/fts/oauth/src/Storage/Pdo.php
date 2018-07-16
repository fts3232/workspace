<?php

namespace fts\OAuth2\Storage;

use OAuth2\Storage\Pdo as PdoStorage;

/**
 * 重写oauth2 pdo storage
 *
 * Class Pdo
 * @package fts\OAuth2\Storage
 */
class Pdo extends PdoStorage
{

    public function __construct($connection, array $config = array())
    {
        parent::__construct($connection, $config);
    }

    /**
     * 用户名验证
     *
     * @param string $username 用户名
     * @return array|bool
     */
    public function getUser($username)
    {
        $stmt = $this->db->prepare($sql = sprintf('SELECT * from %s where %s=:username', $this->config['user_table'],$this->config['user_column_name']));
        $stmt->execute(array('username' => $username));

        if (!$userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        // the default behavior is to use "username" as the user_id
        return array_merge(array(
            'user_id' => $username
        ), $userInfo);
    }

    /**
     * 返回密码加密后的值
     *
     * @param $password 密码
     * @return string
     */
    protected function hashPassword($password)
    {
        if($this->config['password_encrypt'] == 'md5'){
            return md5($password);
        }else{
            return sha1($password);
        }
    }

    /**
     * 检查密码
     *
     * @param array $user 用户信息
     * @param string $password 密码
     * @return bool
     */
    protected function checkPassword($user, $password)
    {
        return $user[$this->config['password_column_name']] == $this->hashPassword($password);
    }
}