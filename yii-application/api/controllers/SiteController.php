<?php
namespace api\controllers;

use api\models\LoginForm;
use api\models\PasswordResetRequestForm;
use api\models\ResendVerificationEmailForm;
use api\models\ResetPasswordForm;
use api\models\SignupForm;
use api\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{

    /**
     * @return LoginForm|\common\models\Token|null
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($token = $model->auth()) {
            return $token;
        } else {
            return $model;
        }
    }

    /**
     * @return SignupForm|array
     */
    public function actionRegistration()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->signup()) {
            return $model;
        }

        return $model->errors;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->validate() && $model->sendEmail()) {
            return true;
        }

        throw new NotFoundHttpException();
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException();
        }

        if ($model->load(\Yii::$app->request->post(), '') && $model->validate() && $model->resetPassword()) {

            return true;
        }

        throw new NotFoundHttpException();
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException();
        }
        if ($user = $model->verifyEmail()) {
            if (\Yii::$app->user->login($user)) {

                return true;
            }
        }

        throw new NotFoundHttpException();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->sendEmail()) {

                return true;
            }
        }

        throw new NotFoundHttpException();
    }
    

    protected function verbs()
    {
        return [
            'login' => ['post'],
        ];
    }
}
