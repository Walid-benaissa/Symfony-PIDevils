<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainsMotCensor extends Constraint
{
    public string $message = 'Votre message contient des mots innaproprié';
    // If the constraint has configuration options, define them as public properties
    public string $mode = 'strict';
}
