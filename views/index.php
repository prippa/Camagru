<?php

$email_a = 'a@a.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.aa.a123456789012';
$email_b = 'bogus';

if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail адрес '$email_a' указан верно.\n";
} else {
    echo "E-mail адрес '$email_a' указан неверно.\n";
}

if (filter_var($email_b, FILTER_VALIDATE_EMAIL)) {
    echo "E-mail адрес '$email_b' указан верно.\n";
} else {
    echo "E-mail адрес '$email_b' указан неверно.\n";
}
