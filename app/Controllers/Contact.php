<?php

namespace App\Controllers;

use App\Forms\ContactForm;

class Contact extends BaseController
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

        if ($data)
        {
            if ($model->validate($data))
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
            else
            {
                $errors = (array) $model->errors();
            }
        }

        return $this->render('contact', [
            'data' => $data,
            'errors' => $errors,
            'message' => $message,
            'model' => $model
        ]);
    }

}