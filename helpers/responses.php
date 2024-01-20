<?php

function vueResponse($message = null, $type = null, $data = null)
{
    $response = [];

    if ($message) {
        $response['message'] = $message;
        $response['type'] = $type ?? 'warning';
    }

    if ($data) {
        $response['data'] = $data;
    }

    return response()->json($response);
}
