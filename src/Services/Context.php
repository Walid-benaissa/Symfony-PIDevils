<?php

namespace App\Service;

class Context
{
    private ?string $mail;
    private ?string $code;
    public function getMail(): string
    {
        return $this->mail;
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
}
