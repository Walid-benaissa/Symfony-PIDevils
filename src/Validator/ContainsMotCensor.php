<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainsMotCensor extends Constraint
{
    public string $mode = 'strict';
        public string $message = 'Votre message contient des mots innaproprié';
    
        // Define the default option
        public string $defaultOption = 'mode';
    
        // If the constraint has configuration options, define them as public properties

}
