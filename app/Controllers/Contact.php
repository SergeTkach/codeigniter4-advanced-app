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
        $reCaptcha2 = false;

        $reCaptcha3 = false;

        $errors = [];

        $customErrors = [];

        $message = null;

        $data = $this->request->getPost();

        $model = new ContactForm;

        if (array_search('reCaptcha2', $model->allowedFields) !== false)
        {
            $reCaptcha2 = true;
        }
        elseif(array_search('reCaptcha3', $model->allowedFields) !== false)
        {
            $reCaptcha3 = true;
        }

        if ($data)
        {
            $data = $model->load($data);

            if ($model->validate($data))
            {
                if ($model->sendEmail($data, $error))
                {   
                    $message = lang('Thank you for contacting us. We will respond to you as soon as possible.');

                    $data = [];
                }
                else
                {
                    if (!CI_DEBUG)
                    {
                        $error = lang('Sorry, we are unable to send a message.');
                    }

                    $customErrors[] = $error;
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
            'model' => $model,
            'customErrors' => $customErrors,
            'reCaptcha2' => $reCaptcha2,
            'reCaptcha3' => $reCaptcha3
        ]);
    }

}