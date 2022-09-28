<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enc
{
    const URL_API = "https://pdunida.net/graduation/wslive/";
    const KEY_API = '4bd1Th3a';
    const CID_API = "5457";

    public static function getWisudawan($wisuda)
    {
        $data = array(
            'client_id'     => self::CID_API,
            'type'            => 'dataWisudawan',
            'wisuda_ke'     => $wisuda,
        );
        return self::send($data);
    }
    public static function encrypt($data)
    {
        return unidaEnc::encrypt($data, self::CID_API, self::KEY_API);
    }

    public static function decrypt($data)
    {
        return unidaEnc::decrypt($data, self::CID_API, self::KEY_API);
    }

    public static function send($data)
    {
        $enc = self::encrypt($data);
        $data = array(
            'client_id' => self::CID_API,
            'data'      => $enc,
        );
        $response = self::get_content(self::URL_API, json_encode($data));
        return  json_decode($response, true);
    }

    private static function get_content($url, $post = '')
    {
        $usecookie = __DIR__ . "/cookie.txt";
        $header[] = 'Content-Type: application/json';
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        // curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $rs = curl_exec($ch);

        if (empty($rs)) {
            var_dump($rs, curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return $rs;
    }
}
