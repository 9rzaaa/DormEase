<?php

return [
    'email_enabled' => env('CONTACT_INQUIRY_EMAIL_ENABLED', false),
    'inquiry_to_email' => env('CONTACT_INQUIRY_TO_EMAIL', env('MAIL_FROM_ADDRESS', 'admin@dormease.com')),
    'inquiry_to_name' => env('CONTACT_INQUIRY_TO_NAME', 'Sanctissimo Rosario Ladies Dormitory'),
];
