<?php

use Infrastructure\Utils\ApiConstants;

$server = $_SERVER["SERVER_NAME"] ?? null;

$application = $documentation = match($server) {
    ApiConstants::SERVER_NAME_DEVELOPMENT => ApiConstants::HOST_API_DEVELOPMENT,
    ApiConstants::SERVER_NAME_HOMOLOGATION => ApiConstants::HOST_API_HOMOLOGATION,
    ApiConstants::SERVER_NAME_PRODUCTION => ApiConstants::HOST_API_PRODUCTION,
    default => ApiConstants::HOST_API_DEVELOPMENT
};

$documentation = match($server) {
    ApiConstants::SERVER_NAME_DEVELOPMENT => ApiConstants::DOCUMENTATION_API_DEVELOPMENT,
    ApiConstants::SERVER_NAME_HOMOLOGATION => ApiConstants::DOCUMENTATION_API_HOMOLOGATION,
    ApiConstants::SERVER_NAME_PRODUCTION => ApiConstants::DOCUMENTATION_API_PRODUCTION,
    default => ApiConstants::DOCUMENTATION_API_DEVELOPMENT,
};

$environment = match($server) {
    ApiConstants::SERVER_NAME_DEVELOPMENT => ApiConstants::ENVIRONMENT_DEVELOPMENT,
    ApiConstants::SERVER_NAME_HOMOLOGATION => ApiConstants::ENVIRONMENT_HOMOLOGATION,
    ApiConstants::SERVER_NAME_PRODUCTION => ApiConstants::ENVIRONMENT_PRODUCTION,
    default => ApiConstants::ENVIRONMENT_DEVELOPMENT
};

return [
    "api_information" => [
        "project"       => "Process Control | API-Process-Control",
        "copyright"     => "Lucas Giori",
        "developedby"   => "LucasGiori",
        "application"   => $application,
        "documentation" => $documentation,
        "environment"   => $environment,
    ],
    "internal_host"   => $application,
];
