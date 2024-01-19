<?php

function successMessage($message, $additional_data = null)
{
    $data = [
        'message' => $message,
        'type' => 'success',
    ];

    if ($additional_data) {
        $data['additional_data'] = $additional_data;
    }

    return response()->json([
        'data' => $data
    ]);
}

function errorResponse($message, $status = 404)
{
    $data = [
        'message' => $message,
        'type' => 'danger',
    ];

    return response()->json([
        'data' => $data
    ], $status);
}

function modelResponse($entity)
{
    return response()->json([
        'data' => $entity
    ]);
}
