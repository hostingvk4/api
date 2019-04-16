<?php
namespace api\controllers;

use api\models\LoginForm;

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

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }
}
