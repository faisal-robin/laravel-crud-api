<?php
if (!function_exists('responseFormat')) {
    function responseFormat($status = 'error', $data = '', $options = []): array
    {
        $response = [''];
        if (!empty($status)) {
            if ($status == 'success') {
                $response = [
                    'status' => $status,
                    'data' => $data,
                ];
            } elseif ($status == 'error') {
                $response = [
                    'status' => $status,
                    'message' => $data,
                ];
                if (!empty($options) && !empty($options['details'])) {
                    $response['details'] = $options['details'];
                }
                if (!empty($options) && !empty($options['reason'])) {
                    $response['reason'] = $options['reason'];
                }
            }
            if (!empty($options) && !empty($options['code'])) {
                $response['code'] = $options['code'];
            }
        }
        return $response;
    }
}

