<?php


namespace MailServer\Validator;


class SwiftMailerValidator extends AbstractValidator
{

    function getRootKey()
    {
        return 'swiftmailer';
    }

    function getKeys()
    {
        return array('host', 'port', 'username', 'password');
    }
}