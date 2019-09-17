<?php

namespace App\Models;

use Config\Services;
use Exception;

class ContactForm extends \App\Components\BaseModel
{

    protected $returnType = \stdClass::class;

    protected $allowedFields = ['name', 'email', 'subject', 'body', 'verifyCode'];

    protected $fieldLabels = [
        'name' => 'Name',
        'email' => 'E-mail',
        'subject' => 'Subject',
        'body' => 'Body',
        'verifyCode' => 'Verification Code'
    ];

    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'subject' => 'required|max_length[255]',
        'body' => 'required|max_length[255]',
        'verifyCode' => 'max_length[255]'
    ];

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail(object $data, $toEmail)
    {
        $email = Services::email();

        if (!$email->fromEmail)
        {
            throw new Exception('From email is not defined.');
        }

        $email->initialize(['mailType' => 'html']);
        
        $email->setTo($toEmail);

        $email->setSubject($data->subject);

        //$message = view('messages/contact', ['data' => $data]);

        $email->setMessage($data->body);

        return $email->send();
    }

}