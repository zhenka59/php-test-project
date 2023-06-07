<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $username = strtolower($this->username);

        $user = User::model()->find('LOWER(username)=?',array($username));

        if($user === null) {

            $this->errorCode = self::ERROR_USERNAME_INVALID;

        }else if(!$user->validatePassword($this->password)){

            $this->errorCode = self::ERROR_PASSWORD_INVALID;

        }else{
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function authByToken($token)
    {
        $this->errorCode = self::ERROR_NONE;
        if (!$token) {
            return false;
        }

        $user = User::model()->find('token=?', [$token]);

        if ($user === null) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } else {
            $this->_id = $user->id;
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }
}