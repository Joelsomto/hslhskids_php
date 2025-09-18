<?php

class ApiAuth
{
    public static function getHeader($name)
    {
        $headers = function_exists('getallheaders') ? getallheaders() : self::fallbackHeaders();
        foreach ($headers as $k => $v) {
            if (strcasecmp($k, $name) === 0) return $v;
        }
        return null;
    }

    private static function fallbackHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$key] = $value;
            }
        }
        return $headers;
    }

    public static function requireApiKey()
    {
        $provided = self::getHeader('X-API-Key') ?? ($_GET['api_key'] ?? ($_POST['api_key'] ?? null));
        $expected = getenv('HSLHS_API_KEY');
        if (!$expected || $expected === '') {
            // fallback constant if env not set
            $expected = 'CHANGE_ME_SECURE_KEY';
        }
        if (!$provided || !hash_equals($expected, $provided)) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }
    }
}

?>
