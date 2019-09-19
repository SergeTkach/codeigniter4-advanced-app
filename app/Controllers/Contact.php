<?php

namespace App\Controllers;

use App\Models\ContactForm;
use Config\Services;
use Exception;

class Contact extends \App\Components\BaseController
{

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function index()
    {
        $errors = [];

        $message = null;

        $data = $this->request->getPost();

        $model = new ContactForm;

        if ($data && $model->validate($data))
        {
            if ($model->sendEmail($data, $error))
            {   
                $message = 'Thank you for contacting us. We will respond to you as soon as possible.';

                $data = [];
            }
            else
            {
                $errors[] = $error;
            }
        }

        return $this->render('contact', [
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors),
            'message' => $message,
            'model' => $model
        ]);
    }

}