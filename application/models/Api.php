<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Model
{
    function kirim()
    {
        $link  =  "https://oauth.gateway.quincus.com/api/v1/auth";
        $curl = curl_init();
        $headers = [
            // 'Content-Type:application/json',
            'x-client-id: PRODTRANSTAMAt9nP4EYy',
            'x-client-secret:PRODTRANSTAMAzv5H2CJG6h4mvzzg'
        ];
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    function order($data)
    {
        $token = $this->session->userdata('token');
        $link  =  "https://gateway.order.quincus.com/open_api/v1/orders";
        $curl = curl_init();
        $headers = [
            'x-ORGANISATION-id:09060a0a-6275-4d0b-a7e1-04c3fdbf770f',
            "x-client-token: $token",
            'x-client-id:PRODTRANSTAMAt9nP4EYy',
            'Content-Type: application/json'
        ];
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    function http_request($url)
    {
        // persiapkan curl
        $ch = curl_init();

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url);

        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string 
        $output = curl_exec($ch);

        // tutup curl 
        curl_close($ch);
        return $output;
    }
    function kirim2()
    {
        $link  =  "https://oauth.gateway.quincus.com/api/v1/auth";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://oauth.gateway.quincus.com/api/v1/auth");
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            // 'Content-Type:application/json',
            'x-client-id: PRODTRANSTAMAt9nP4EYy',
            'x-client-secret:PRODTRANSTAMAzv5H2CJG6h4mvzzg'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);
        curl_close($ch);
        // curl_setopt($curl, CURLOPT_URL, $link);
        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($curl);
        // curl_close($curl);
        var_dump($server_output);
        die;
        return $server_output;
    }
}
