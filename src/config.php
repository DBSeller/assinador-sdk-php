<?php

return [
    "certificate" => [
        "url" => env("SIGNER_CERTIFICATE_URL", ""),
        "user" => env("SIGNER_CERTIFICATE_USER", ""),
        "password" => env("SIGNER_CERTIFICATE_PASSWORD", "")
    ],
    "signer" => [
        "url" => env("SIGNER_URL", ""),
        "user" => env("SIGNER_USER", ""),
        "password" => env("SIGNER_PASSWORD", "")
    ]
];