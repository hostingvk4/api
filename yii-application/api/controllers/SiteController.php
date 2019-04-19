<?php
namespace api\controllers;

use api\models\LoginForm;
use api\models\SignupForm;

/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return 'api';
    }
    
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(\Yii::$app->request->bodyParams, '');
        if ($token = $model->auth()) {
            return $token;
        } else {
            return $model;
        }
    }

    public function actionRegistration()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->bodyParams, '') && $model->signup()) {
            return $model;
        }
        return $model->errors;
    }
    

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }
}
