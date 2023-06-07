<?php


class ApiController extends Controller
{
    public function actionCreate()
    {
        $post = Yii::app()->request->rawBody;
        $data = CJSON::decode($post, true);
        $model = new User();
        $model->email = $data['email'];
        $model->username = $data['username'];
        $model->password = $model->hashPassword($data['password']);
        if($model->validate()) {
            $model->save();
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo CJSON::encode($model->getErrors());
        }
    }

    public function actionLogin()
    {
        header('Content-Type: application/json');

        $user = Yii::app()->request->rawBody;
        $data = CJSON::decode($user, true);
        $identity = new UserIdentity($data['username'], $data['password']);

        if ($identity->authenticate()) {
            $user = User::model()->findByPk($identity->getId());
            $user->token = $this->generateToken();
            if ($user->save()) {
                echo CJSON::encode(['token' => $user->token]);
            }else {
                echo CJSON::encode($user->getErrors());
            }

        } else {
            echo $identity->errorCode;
        }
    }

    public function generateToken($length = 64)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}
