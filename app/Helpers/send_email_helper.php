<?php

if (!function_exists('send_email'))
{
    function send_email($email, &$error = null)
    {
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