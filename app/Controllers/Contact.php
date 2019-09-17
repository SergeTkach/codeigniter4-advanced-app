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

        $messages = [];

        $data = $this->request->getPost();

        $model = new ContactForm;

        if ($data && $model->validate($data))
        {
            $email = Services::email();

            if (!$email->fromEmail)
            {
                throw new Exception('From email is not defined.');
            }

            if ($model->sendEmail((object) $data, $email->fromEmail))
            {   
                $messages[] = 'Thank you for contacting us. We will respond to you as soon as possible.';

                $data = [];
            }
            else
            {
                if (CI_DEBUG)
                {
                    $errors[] = $email->printDebugger([]); 
                }
                else
                {
                    $errors[] = 'There was an error sending your message.';
                }
            }
        }
        else
        {
            $errors = (array) $model->errors();
        }

        $data = (object) $data;

        return $this->render('contact', [
            'data' => $data,
            'errors' => $errors,
            'messages' => $messages,
            'model' => $model
        ]);
    }

}