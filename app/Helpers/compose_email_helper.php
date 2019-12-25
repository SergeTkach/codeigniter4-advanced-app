<?php

use Config\Services;

if (!function_exists('compose_email'))
{
    function compose_email(string $view, array $params = [], array $options = [])
    {
        $message = view($view, $params, ['saveData' => false]);

        $view = Services::renderer();

        $data = $view->getData();

        $subject = $data['subject'] ?? null;

        $mailType = $data['mailType'] ?? 'html';

        $email = Services::email();

        $options = array_merge(['mailType' => $mailType], $options);

        $email->initialize($options);

        if ($subject)
        {
            $email->setSubject($subject);
        }

        $email->setMessage($message);

        return $email;
    }
}