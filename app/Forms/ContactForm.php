<?php

namespace App\Forms;

use Config\Services;
use Config\Email as EmailConfig;
use Exception;

class ContactForm extends \CodeIgniter\Model
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
        $email = compose_email('messages/contact', $data);

        $config = config(EmailConfig::class);

        $email->setTo($config->fromEmail, $config->fromName);

        $email->setReplyTo($data['email'], $data['name']);

        return send_email($email, $error);
    }

}