<?php

namespace Phpdev;

Class Ziraatkatilim
{
    
    
    public $username = "";
    public $pasword = "";
    public $customerno = "";
    
    function __construct($username, $password, $customerno)
    {
        $this->username       = $username;
        $this->password       = $password;
        $this->customerno     = $customerno;
    }
    
    
    
    public function hesap_hareketleri($tarih1, $tarih2)
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_PORT => "8443",
          CURLOPT_URL => "https://zkapigw.ziraatkatilim.com.tr:8443/api/accountService",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => '{"associationCode":"'.$this->customerno.'","startDate":"'.$tarih1.'", "endDate":"'.$tarih2.'"}',
          CURLOPT_HTTPHEADER => array(
            "authorization: Basic ".base64_encode($this->username.":".$this->password)."",
            "content-type: application/json"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response);
        if(isset($response->AccountReportV2Response->AccountReportV2Result->AccountDetail)){
            return json_encode([
                'statu'=>true,
                'response' => $response
            ]);
        } else {
            return json_encode([
                'statu'=>false,
                'response' => 'Bir hata oluştu, bilgileri kontrol ediniz.'
            ]);
        }
    }
    
    
}