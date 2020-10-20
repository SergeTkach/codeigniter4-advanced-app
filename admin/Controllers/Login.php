<?php

namespace Admin\Controllers;

use Admin\Forms\LoginForm;
use Exception;

class Login extends BaseController
{

    protected function checkAuth() : bool
    {
        return true;
    }

    public function index()
    {
        if ($this->admin)
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
                $user = adminAuth()->getModel()->find($data['username']);

                if (!$user)
                {
                    throw new Exception(lang('Admin not found.'));
                }

                $rememberMe = array_key_exists('rememberMe', $data) ? $data['rememberMe'] : false;

                adminAuth()->login($user, $rememberMe);

                return $this->goHome();
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

        return $this->render('login', [
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
        adminAuth()->logout();

        return $this->goHome();
    }

}