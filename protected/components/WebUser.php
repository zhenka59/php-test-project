<?php
class WebUser extends CWebUser
{
    public function init() {
        $token = Yii::app()->request->getParam('token' ,null);
        if (!$token) {
            $this->logout();
            return;
        }

        $identity = new UserIdentity('', '');

        if ($identity->authByToken($token)) {
            $this->login($identity);
        }
    }

}
