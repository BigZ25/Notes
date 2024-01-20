<?php

include('validator.php');
include('responses.php');

function passwordRegexRule(): string
{
    return 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
}
