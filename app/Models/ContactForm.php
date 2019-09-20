<?php

namespace App\Models;

use Config\Services;
use Config\Mailer as MailerConfig;
use Exception;

class ContactForm extends \App\Components\Model
{

    protected $returnType = 'array';

    protected $allowedFields = [
        'name', 
        'email', 
        'subject', 
        'body'
    ];
    
    protected $validationRules = [
        'name' => [
            'rules' => 'required|max_length[255]',
            'label' => 'Name'
        ],
        'email' => [
            'rules' => 'required|valid_email|max_length[255]',
            'label' => 'Email'
        ],
        'subject' => [
            'rules' => 'required|max_length[255]',
            'label' => 'Subject' 
        ],
        'body' => [
            'rules' => 'required|max_length[255]',
            'label' => 'Body'
        ]
    ];

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($data, &$error)
    {
        foreach($data as $key => $value)
        {
            $data[$key] = trim(strip_tags($value));
        }

        $mailerConfig = config(MailerConfig::class);

        $email = Services::email();

        $email->initialize(['mailType' => 'text']);

        $email->setFrom($mailerConfig->fromEmail, $mailerConfig->fromName);
        
        $email->setTo($mailerConfig->fromEmail, $mailerConfig->fromName);

        $email->setReplyTo($data['email'], $data['name']);

        $email->setSubject($data['subject']);

        $email->setMessage($data['body']);

        $return = $email->send();

        if (!$return)
        {
            if (CI_DEBUG)
            {
                $error = $email->printDebugger([]); 
            }
            else
            {
                $error = 'There was an error sending your message.';
            }
        }

        return $return;
    }

}