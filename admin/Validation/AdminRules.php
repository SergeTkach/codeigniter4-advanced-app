<?php

namespace Admin\Validation;

class AdminRules
{

    protected function getAdmin(array $data, &$error = null) : ?array
    {
        $model = adminAuth()->getModel();

        $user = $model->find($data['username']);

        if ($user && $model->validatePassword($user, $data['password']))
        {
            return $user;
        }

        $error = lang('Admin not found or password incorrect.');

        return null;
    }

    public function validAdmin($email, $reserved, array $data, &$error = null) : bool
    {
        if (empty($data['password']) || empty($data['username']))
        {
            return true;
        }

        return $this->getAdmin($data, $error) ? true : false;
    }

}