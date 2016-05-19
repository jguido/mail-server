<?php


namespace MailServer\Validator;


abstract class AbstractValidator implements IValidator
{

    public function validate(array $config)
    {
        if (count($this->getKeys()) === 0) {
            throw new \RuntimeException("Array keys must no be empty!");
        }
        $this->notNullAndNotEmpty($config, $this->getRootKey());

        foreach ($this->getKeys() as $key) {
            $this->notNullAndNotEmpty($config[$this->getRootKey()], $key);
        }

        return true;
    }

    private static function notNullAndNotEmpty(array $input, $key)
    {
        if (!isset($input[$key]) || empty($input[$key])) {
            throw new \RuntimeException(sprintf("Config key %s must be set", $key));
        }

        return true;
    }
}