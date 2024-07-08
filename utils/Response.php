<?php

class Response {
    public static function success($data) {
        http_response_code(200);
        echo json_encode([
            'status' => 200,
            'message' => 'OK',
            'data' => $data
        ]);
    }

    public static function error($code, $message) {
        http_response_code($code);
        echo json_encode([
            'status' => $code,
            'message' => $message
        ]);
    }
}
