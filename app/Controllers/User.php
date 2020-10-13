<?php

namespace App\Controllers;

use Exception;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Forms\LoginForm;
use App\Forms\SignupForm;
use App\Forms\PasswordResetRequestForm;
use App\Forms\ResendVerificationEmailForm;
use App\Forms\ResetPasswordForm;
use App\Forms\UserModel;

class User extends BaseController
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

        if ($data)
        {
            if ($model->validate($data))
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
            else
            {
                $errors = (array) $model->errors();
            }
        }

        return $this->render('user/signup', [
            'model' => $model,
            'data' => $data,
            'errors' => $errors
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
        
        if ($data)
        {
            if ($model->validate($data))
            {
                $rememberMe = array_key_exists('rememberMe', $data) ? $data['rememberMe'] : 0;

                $user = $model->getUser();

                if ($this->user->login($user, (bool) $rememberMe, $error))
                {
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
        }
        else
        {
            $data['rememberMe'] = 1;
        }

        return $this->render('user/login', [
            'model' => $model,
            'errors' => $errors,
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
    public function verifyEmail($id, $token)
    {
        $model = new UserModel;

        $user = $model->find((int) $id);

        if (!$user)
        {
            throw new PageNotFoundException;
        }

        if ($user->email_verified_at)
        {
            throw new Exception('User already verified.');
        }

        if ($user->email_verification_token != $token)
        {
            throw new Exception('Unable to verify your account with provided token.');
        }

        $model->set('email_verified_at', 'NOW()', false);

        $model->set('email_verification_token', 'NULL', false);

        $model->protect(false);

        if (!$model->update($id))
        {
            $errors = $model->errors();

            $error = array_shift($errors);

            throw new Exception($error);
        }

        $this->session->setFlashdata('success', 'Your email has been confirmed!');

        return $this->redirect(site_url('user/login'));
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

        if ($data)
        {
            if ($model->validate($data))
            {
                $user = $model->getUser();

                $userModel = new UserModel;

                if (!$userModel->isTokenValid($user->email_verification_token))
                {
                    $user->email_verification_token = $userModel->generateToken();

                    if (!$userModel->save($user))
                    {
                        $errors = $userModel->errors();

                        $error = array_shift($error);

                        throw new Exception($error);
                    }
                }

                if ($model->sendEmail($user, $error))
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
        }

        return $this->render('user/resendVerificationEmail', [
            'model' => $model,
            'data' => $data,
            'errors' => $errors
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

        if ($data)
        {
            if ($model->validate($data))
            {
                $userModel = new UserModel;

                $user = $model->getUser();

                if (!$user)
                {
                    throw new Exception('User not found.');
                }

                if (!$user->password_reset_token || !$userModel->isTokenValid($user->password_reset_token))
                {
                    $user->password_reset_token = $userModel->generateToken();

                    if (!$userModel->save($user))
                    {
                        $errors = $userModel->errors();

                        $error = array_shift($errors);

                        throw new Exception($error);
                    }
                }

                if ($model->sendEmail($user, $error))
                {
                    $this->session->setFlashdata('success', 'Check your email for further instructions.');

                    return $this->goHome();
                }
                else
                {
                    //'Sorry, we are unable to reset password for the provided email address.'

                    $errors[] = $error; 
                }
            }
            else
            {
                $errors = (array) $model->errors();
            }
        }
        
        return $this->render('user/requestPasswordReset', [
            'model' => $model,
            'data' => $data,
            'errors' => $errors
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     */
    public function resetPassword($id, $token)
    {
        $userModel = new UserModel;

        $user = $userModel->find((int) $id);

        if (!$user)
        {
            throw new PageNotFoundException;
        }

        if ($token != $user->password_reset_token)
        {
            throw new Exception('Wrong password reset token.');
        }

        $errors = [];

        $model = new ResetPasswordForm;

        $data = $this->request->getPost();

        if ($data)
        {
            if ($model->validate($data))
            {
                if ($model->resetPassword($user, $data, $error))
                {
                    $this->session->setFlashdata('success', 'New password saved.');

                    return $this->redirect(site_url('user/login'));
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
        }

        return $this->render('user/resetPassword', [
            'model' => $model,
            'data' => $data,
            'errors' => $errors,
            'id' => $id,
            'token' => $token
        ]);
    }

}