<?php

return [
    'ERROR_CODES' => [
        'SYNTAX_ERROR' => 'syntax_error',
        'UNAUTHENTICATED' => 'unauthenticated',
        'UNAUTHORIZED' => 'unauthorized',
        'RESOURCE_NOT_FOUND' => 'resource_not_found',
        'VALIDATION_FAILED' => 'validation_failed',
        'SERVER_ERROR' => 'server_error'
    ],
    'ERROR_MESSAGES' => [
        'SYNTAX_ERROR' => 'Couldn\'nt understand the request.',
        'UNAUTHENTICATED' => 'You are not authenticated.',
        'UNAUTHORIZED' => 'You are not authorized to make this request.',
        'RESOURCE_NOT_FOUND' => 'The requested resource does not exist.',
        'VALIDATION_FAILED' => 'The given data failed to pass validation.',
        'SERVER_ERROR' => 'Server is dead.'
    ],
    'HTTP_CODES' => [
        'SUCCESS' => 200,
        'CREATE_SUCCESS' => 201,
        'SYNTAX_ERROR' => 400,
        'UNAUTHENTICATED' => 401,
        'UNAUTHORIZED' => 403,
        'RESOURCE_NOT_FOUND' => 404,
        'VALIDATION_FAILED' => 422,
        'SERVER_ERROR' => 500
    ]
];