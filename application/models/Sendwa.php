<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sendwa extends CI_Model
{
    function kirim2($phone, $msg)
    {
        $link  =  "https://pati.wablas.com";
        $data = [
            'phone' => $phone,
            'message' => $msg,
        ];

        $curl = curl_init();
        $token =  "QQyBPckMO6InL8uvhvuqXa44THR0FjZM1EgBu4aKJ6bRRR8HQ7JHKljx8ZpibCqr";
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
        $curl = curl_init();
        $token = "QQyBPckMO6InL8uvhvuqXa44THR0FjZM1EgBu4aKJ6bRRR8HQ7JHKljx8ZpibCqr";
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
        curl_setopt($curl, CURLOPT_URL, "https://pati.wablas.com");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    public function pickup($phone, $msg)
    {
        $result = file_get_contents("https://pati.wablas.com/api/send-message?token=QQyBPckMO6InL8uvhvuqXa44THR0FjZM1EgBu4aKJ6bRRR8HQ7JHKljx8ZpibCqr&phone=$phone&message=$msg");
        return $result;
        // echo "<pre>";
        // print_r($result);
    }
}
