<?php

namespace App\Http\Services\Gateway\nagad;



use App\Http\Services\CurlService;
use App\Http\Services\PaymentService;
use App\Models\Admin\PaymentMethod;
use App\Models\PaymentLog;
use Config;
use Illuminate\Support\Arr;

class Payment
{


    private $tnxID;
    public $nagadHost;
    private $tnxStatus = false;
    public $amount;
    private $merchantAdditionalInfo = [];
    public static function paymentData(PaymentLog $log)
    {
   
        date_default_timezone_set('Asia/Dhaka');
        $gateway = ($log->method->parameters);
  
        if ($gateway->sandbox === '1') {
            $sandbox = true;
            $nagadHost = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs";
        }else{
            $sandbox = false;
            $nagadHost = "https://api.mynagad.com/api/dfs";
        }
        
        $config = [
            'sandbox'=>   $sandbox ,
            'merchant_id'=> $gateway->marchent_id ,
            'merchant_number'=>  $gateway->marchent_number ,
            'public_key'=>  $gateway->pub_key ,
            'private_key'=>  $gateway->pri_key ,
            'callbackURL'=>   route('ipn', [$log->method->code, $log->transaction]) ,
            "timezone" => "Asia/Dhaka"
        ];

        Config::set('nagad',  $config );
        $trx_id = $log->transaction;
        $redirectUrl = (new Payment())->tnxID($trx_id)
                 ->amount(round($log->final_amount))
                 ->getRedirectUrl($nagadHost);
           

        if($redirectUrl){
            $send['redirect'] = true;
            $send['redirect_url'] = $redirectUrl;      
        }
        else{
            $send['error'] = true;
            $send['message'] = "Invalid Request";
        }
    
        return json_encode($send);

    }

    public static function ipn(mixed $request, PaymentMethod $gateway, PaymentLog $log = null,mixed $trx = null, mixed $type = null)
    {
        if($request->status && $request->status == "Success"){
            PaymentService::make_payment($log);
            $data['status'] = 'success';
            $data['msg'] = trans('default.trx_success');   

            $data['redirect'] = route('success');
            return $data;
       }
       else {
        $data['status'] = 'error';
        $data['msg'] = translate('Payment Cancel.');
        $data['redirect'] = route('failed');
       }

    }


    

    public function tnxID($id,$status=false)
    {
        $this->tnxID = $id;
        $this->tnxStatus = $status;
        return $this;
    }


    public function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }


    public function getRedirectUrl($nagadHost)
    {

        $DateTime = Date('YmdHis');
        $MerchantID = config('nagad.merchant_id');
        $invoiceNo =  $this->tnxStatus ? rand(000000,999999) :'Inv'.Date('YmdH').rand(1000, 10000);
        $merchantCallbackURL = config('nagad.callback_url');
        

        $SensitiveData = [
            'merchantId' => config('nagad.merchant_id'),
            'datetime' => $DateTime,
            'orderId' => $invoiceNo,
            'challenge' => Payment::generateRandomString()
        ];
        

        $PostData = array(
            'accountNumber' =>config('nagad.merchant_number'),
            'dateTime' => $DateTime,
            'sensitiveData' => Payment::EncryptDataWithPublicKey(json_encode($SensitiveData)),
            'signature' => Payment::SignatureGenerate(json_encode($SensitiveData))
        );

        $initializeUrl = $nagadHost."/check-out/initialize/".$MerchantID."/" . $invoiceNo;
  

        $Result_Data = Payment::HttpPostMethod($initializeUrl,$PostData);

    
        if (isset($Result_Data['sensitiveData']) && isset($Result_Data['signature'])) {
            if ($Result_Data['sensitiveData'] != "" && $Result_Data['signature'] != "") {

                $PlainResponse = json_decode(Payment::DecryptDataWithPrivateKey($Result_Data['sensitiveData']), true);

                if (isset($PlainResponse['paymentReferenceId']) && isset($PlainResponse['challenge'])) {

                    $paymentReferenceId = $PlainResponse['paymentReferenceId'];
                    $randomserver = $PlainResponse['challenge'];

                    $SensitiveDataOrder = array(
                        'merchantId' =>  config('nagad.merchant_id'),
                        'orderId' => $invoiceNo,
                        'currencyCode' => '050',
                        'amount' => $this->amount,
                        'challenge' => $randomserver
                    );


                    // $merchantAdditionalInfo = '{"no_of_seat": "1", "Service_Charge":"20"}';
                    if($this->tnxID !== ''){
                        $this->merchantAdditionalInfo['tnx_id'] =  $this->tnxID;
                    }

                    $PostDataOrder = array(
                        'sensitiveData' => Payment::EncryptDataWithPublicKey(json_encode($SensitiveDataOrder)),
                        'signature' => Payment::SignatureGenerate(json_encode($SensitiveDataOrder)),
                        'merchantCallbackURL' => $merchantCallbackURL,
                        'additionalMerchantInfo' => (object)$this->merchantAdditionalInfo
                    );
                    // order submit
                    $OrderSubmitUrl = $nagadHost."/check-out/complete/" . $paymentReferenceId;
                    $Result_Data_Order = Payment::HttpPostMethod($OrderSubmitUrl, $PostDataOrder);
                        if ($Result_Data_Order['status'] == "Success") {
                            $callBackUrl = ($Result_Data_Order['callBackUrl']);
                            return $callBackUrl;
                            //echo "<script>window.open($url, '_self')</script>";
                        }
                        else {
                            echo json_encode($Result_Data_Order);
                        }
                } else {
                    echo json_encode($PlainResponse);
                }
            }
        }
        else{
            return null;
        }

    }


    public static function generateRandomString($length = 40)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Generate public key
     */
    public static function EncryptDataWithPublicKey($data)
    {
        $pgPublicKey = config('nagad.public_key');
  
        $public_key = "-----BEGIN PUBLIC KEY-----\n" . $pgPublicKey . "\n-----END PUBLIC KEY-----";
 
        $key_resource = openssl_get_publickey($public_key);
        openssl_public_encrypt($data, $crypttext, $key_resource);
        return base64_encode($crypttext);
    }

    /**
     * Generate signature
     */
    public static function SignatureGenerate($data)
    {
        $merchantPrivateKey = config('nagad.private_key');
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";

        openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    /**
     * get clinet ip
     */
    public static function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function DecryptDataWithPrivateKey($crypttext)
    {
        $merchantPrivateKey = config('nagad.private_key');
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey. "\n-----END RSA PRIVATE KEY-----";
        openssl_private_decrypt(base64_decode($crypttext), $plain_text, $private_key);
        return $plain_text;
    }

    public static function HttpPostMethod($PostURL, $PostData)
    {
        $url = curl_init($PostURL);
        
      
        $posttoken = json_encode($PostData);
        $header = array(
            'Content-Type:application/json',
            'X-KM-Api-Version:v-0.2.0',
            'X-KM-IP-V4:' . self::get_client_ip(),
            'X-KM-Client-Type:PC_WEB'
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, 0);
        $resultdata = curl_exec($url);
        $curl_error = curl_error($url);
        
   
      
        if (!empty($curl_error)) {
            return [
                'error' => $curl_error
            ];
        }
        
   
        $ResultArray = json_decode($resultdata, true);

        curl_close($url);
        return $ResultArray;

    }

    public static function HttpGet($url)
    {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/0 (Windows; U; Windows NT 0; zh-CN; rv:3)");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $file_contents = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return $file_contents;
    }




}