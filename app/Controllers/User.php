<?php

namespace App\Controllers;

use Exception;
use App\Models\LoginForm;
use App\Models\SignupForm;
use App\Models\PasswordResetRequestForm;

class User extends \App\Components\BaseController
{

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function signup()
    {
        $model = new SignupForm;

        $data = $this->request->getPost();

        $errors = [];

        if ($data && $model->validate($data))
        {
            if (($user = $model->signup($data, $error)) && $model->sendEmail($user, $error))
            {
                $this->session->setFlashdata(
                    'success', 
                    'Thank you for registration. Please check your inbox for verification email.'
                );
            
                return $this->goHome();
            }
            else
            {
                $errors[] = $error;
            }
        }

        return $this->render('user/signup', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function login()
    {
        if (!$this->user->isGuest())
        {
            return $this->goHome();
        }

        $model = new LoginForm;

        $data = $this->request->getPost();

        $errors = [];
        
        if ($data && $model->validate($data))
        {
            $rememberMe = array_key_exists('rememberMe', $data) ? $data['rememberMe'] : 0;

            $user = $model::getUser();

            if ($this->user->login($user, $rememberMe, $error))
            {
                return $this->goBack();
            }
            else
            {
                $errors[] = $error;
            }
        }

        return $this->render('user/login', [
            'model' => $model,
            'errors' => array_merge((array) $model->errors(), $errors),
            'data' => $data
        ]);        
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function logout()
    {
        $this->user->logout();

        return $this->goHome();
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return mixed
     */
    public function verifyEmail($token)
    {
        $model = new VerifyEmailForm;

        $data = $this->request->getPost();

        $data['token'] = $token;

        if ($data && $model->validate($data))
        {
            $user = $model->getUser();

            if ($this->user->login($user))
            {
                $this->session->setFlashdata('success', 'Your email has been confirmed!');

                return $this->goHome();
            }
        }

        $this->session->setFlashdata('error', 'Sorry, we are unable to verify your account with provided token.');
        
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function resendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm;
        
        $errors = [];

        $data = $this->request->getPost();

        if ($post && $model->validate($post))
        {
            if ($model->sendEmail($post, $error))
            {
                $this->session->setFlashdata('success', 'Check your email for further instructions.');
            
                return $this->goHome();
            }
            else
            {
                $errors[] = $error;
            }
        }
        else
        {
            $errors = (array) $model->errors();
        }

        return $this->render('user/resendVerificationEmail', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function requestPasswordReset()
    {
        $model = new PasswordResetRequestForm;

        $data = $this->request->getPost();

        $errors = [];
        
        if ($data && $model->validate($data))
        {
            if ($model->sendEmail($data, $error))
            {
                $this->session->setFlashdata('success', 'Check your email for further instructions.');

                return $this->goHome();
            }
            else
            {
                $errors[] = $error;
            }
        }

        $data = (object) $data;

        return $this->render('user/requestPasswordReset', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     */
    public function resetPassword($token)
    {
        try
        {
            $model = new ResetPasswordForm($token);
        }
        catch(Exception $e)
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword())
        {
            $this->session->setFlashdata('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('user/resetPassword', [
            'model' => $model
        ]);
    }

}