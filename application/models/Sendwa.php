<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sendwa extends CI_Model
{
    function kirim2($phone, $msg)
    {
        $msg = htmlspecialchars($msg);
        $link  =  "https://jogja.wablas.com";
        $data = [
            'phone' => $phone,
            'message' => $msg,
        ];

        $curl = curl_init();
        $token =  "uk6mWOZvwaEOTprR9NE64FlNy3X0Wa0EVvFcXC6byLvd9zTjTxL0XUlj8PlEEQ4D";
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    public function kirim($phone, $msg)
    {
        $msg = htmlspecialchars($msg);
        $curl = curl_init();
        $token = "uk6mWOZvwaEOTprR9NE64FlNy3X0Wa0EVvFcXC6byLvd9zTjTxL0XUlj8PlEEQ4D";
        $data = [
            'phone' => $phone,
            'message' => $msg,
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    public function pickup($phone,$msg)
    {

      $msg =  str_replace(" ", "%20", $msg);

        $result = file_get_contents("https://jogja.wablas.com/api/send-message?token=dIcrt40Ek2SdegCv9KnkYQEVBFTyUxyztNMjTtB6ZxbQlhzYWrfbDgCGS8CVqLro.UftRIN0F&phone=$phone&message=$msg");
        return $result;
        // echo "<pre>";
        // print_r($result);
    }
}
