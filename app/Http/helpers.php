<?php



use App\User;
use Illuminate\Support\Facades\Cache;



 function sendSMS( $phone, $message ){


    $curl = curl_init();
    $phone =substr($phone, 1);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://msegat.com/gw/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"userName\"\r\n\r\nthnyan asiri\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"apiKey\"\r\n\r\nbffac502ccce2e110baa065de913a5a8\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"numbers\"\r\n\r\n966".$phone."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"userSender\"\r\n\r\nQarib\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"msg\"\r\n\r\n".$message." \r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"By\"\r\n\r\nLink\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            "postman-token: 79d2304a-e79c-9dcb-7714-882b4fcdfcfa"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);




}



function sendFCM($title, $body, $data, $tokens, $badge)
{


    $notif = new  \App\Notifications ;
    $notif->user_id =  $data['user_id'];
    $notif->action_type =$data['action_type']  ;
    $notif->action_id  = $data['action_id'] ;
    $notif-> title_ar = $data['title_ar'] ;
    $notif-> body_ar = $data['body_ar']  ;
    $notif-> title_en =$data['title_en']  ;
    $notif-> body_en = $data['body_en'];
    $date = Carbon\Carbon::now()->toDateTimeString();
    if($date){
        $notif-> date =   $date;
        $notif->save();
    }
    $notif->save();

    $user = User::where('id' , $notif->user_id)->where('active_notif' , 1)->first() ;
    if($user){

        $count_unread=\App\Notifications::where('user_id' , $data['user_id'] )->where('is_read' , 0 )->count();


        $newData['action_type'] = $data['action_type'] ;
        $newData['action_id'] = $data['action_id'] ;
        $newData['date'] = $data['date'] ;


        $optionBuilder = new \LaravelFCM\Message\OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);


        $notificationBuilder = new \LaravelFCM\Message\PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
             ->setSound('default')
             ->setBadge($count_unread);

        $dataBuilder = new \LaravelFCM\Message\PayloadDataBuilder();
        $dataBuilder->addData(['data' => (object) $newData ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = \LaravelFCM\Facades\FCM::sendTo($tokens, $option, $notification, $data);

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $object = [
            'numberSuccess' => $downstreamResponse->numberSuccess(),
            'numberFailure' => $downstreamResponse->numberFailure(),
            'numberModification' => $downstreamResponse->numberModification(),
        ];


        return $object;
    }

}


function uploadFile($file, $dest)
{
    $path = 'images/' . $dest;
    $ext = $file->guessClientExtension();
    $filename = time() . str_random(25) . '.' . $ext;
    $file->move($path, $filename);
    return $filename;
}


function jsonResponse($status, $message, $data=null, $code=null, $page= null , $page_count=null ,$validator=null)
{

    try {


        $result['status'] = $status;
        $result['message'] = $message;


        if($data === []){
            $result['items'] = [];
        }elseif($data != null ){
            $result['items'] = $data ;
        }

        if($code){
            $result['code'] = $code;
        }
        if($page){
            $result['page'] = $page;
        }
        if($page_count){
            $result['page_count'] = $page_count;
        }



        if ($validator && $validator->fails()) {

            $messages = $validator->errors()->toArray();
            foreach ($messages as $key => $row) {
                $errors['field'] = $key;
                $errors['message'] = $row[0];
                $arr[] = $errors;
            }

            $result['items'] =$arr;

        }
        // dd('m');
         // return response()->json($result, 200, [], JSON_NUMERIC_CHECK);

          return response()->json($result);
    } catch (Exception $ex) {
        return response()->json([
            'line' => $ex->getLine(),
            'message' => $ex->getMessage(),
            'getFile' => $ex->getFile(),
            'getTrace' => $ex->getTrace(),
            'getTraceAsString' => $ex->getTraceAsString(),
        ], $code);
    }
}



function admin_assets($dir)
{
    return url('/admin_assets/assets/' . $dir);
}

function getLocal()
{
    return app()->getLocale();
}



function convertAr2En($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
    return $englishNumbersOnly;
}

function payment( $email, $amount, $order_id)
{
    $url = 'https://maktapp.credit/v3/AddTransaction';
    $data =  array('token'=> '5F127A9C-23A2-4787-90BA-427014D735A8',
        'amount'  => $amount ,
        'currencyCode' => 'QAR' ,
        'orderId' => $order_id,
        'note' => ' test payment' ,
        'lang' => 'ar' ,
        'customerEmail' => $email   ,
        'customerCountry' => 'qatar'
    );
    $options = array();
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($data)
    );
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function validatePayment($order_id)
{
    $url = 'https://maktapp.credit/v3/ValidatePayment';
    $data =  array('token'=> '5F127A9C-23A2-4787-90BA-427014D735A8',
        'orderId' => $order_id
    );
    $options = array();
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($data)
    );
    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

function random_number($digits)
{
    return str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
}

function type()
{
    return [__('common.store'),__('common.product'),__('common.url')];
}

function position()
{
    return [__('common.site'),__('common.mobile')];
}

function typeArrive()
{


    return[
        '1'=>__('print.delivery'),
        '2'=>__('print.pickup'),
        '3'=>__('print.both')
    ];

}

function optionArrive()
{
    return[

        '1'=>__('print.have_delivery_team'),
        '2'=>__('print.link_delivery_company'),
        '3'=>__('print.both')
    ];

}

function sendNotificationToUsers( $tokens_android, $tokens_ios, $order_id, $message )
{
    try {
        $headers = [
            'Authorization: key=AAAAmx9XTuw:APA91bEhmJOmE4HRvBcuIDZNC40HYD4NNZL5oGM0KkwcLb_wGCPhyiIgZsTiaBPDQZtID2adZU29uy_vUMLXFW8wXBqDAHb1xvoGHuJ1_GbtdJSdaAdVLrslAYOFiYbhyVeJURZmBUrK',
            'Content-Type: application/json'
        ];

        if(!empty($tokens_ios)) {
            $dataForIOS = [
                "registration_ids" => $tokens_ios,
                "notification" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 2,//order
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForIOS));
            $result = curl_exec($ch);
            curl_close($ch);
            // $resultOfPushToIOS = "Done";
            //   return $result; // to check does the notification sent or not
        }
        if(!empty($tokens_android)) {
            $dataForAndroid = [
                "registration_ids" => $tokens_android,
                "data" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 2,//order
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForAndroid));
            $result = curl_exec($ch);
            curl_close($ch);
            //    $resultOfPushToAndroid = "Done";
        }
        //   return $resultOfPushToIOS." ".$resultOfPushToAndroid;
        //    return $result;
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }





}

function sendNotificationToUsersChat( $tokens_android, $tokens_ios, $order_id, $message )
{
    try {
        $headers = [
            'Authorization: key=AAAAmx9XTuw:APA91bEhmJOmE4HRvBcuIDZNC40HYD4NNZL5oGM0KkwcLb_wGCPhyiIgZsTiaBPDQZtID2adZU29uy_vUMLXFW8wXBqDAHb1xvoGHuJ1_GbtdJSdaAdVLrslAYOFiYbhyVeJURZmBUrK',
            'Content-Type: application/json'
        ];

        if(!empty($tokens_ios)) {
            $dataForIOS = [
                "registration_ids" => $tokens_ios,
                "notification" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 1,//chat
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForIOS));
            $result = curl_exec($ch);
            curl_close($ch);
            // $resultOfPushToIOS = "Done";
            //   return $result; // to check does the notification sent or not
        }
        if(!empty($tokens_android)) {
            $dataForAndroid = [
                "registration_ids" => $tokens_android,
                "data" => [
                    'body' => $message,
                    'type' => "notify",
                    'title' => 'Karm',
                    'order_id' => $order_id,
                    'badge' => 1,
                    'typeMsg' => 1,//chat
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataForAndroid));
            $result = curl_exec($ch);
            curl_close($ch);
            //    $resultOfPushToAndroid = "Done";
        }
        //   return $resultOfPushToIOS." ".$resultOfPushToAndroid;
        //    return $result;
    } catch (\Exception $ex) {
        return $ex->getMessage();
    }





}

function slugURL($title){
    $WrongChar = array('@', '؟', '.', '!','?','&','%','$','#','{','}','(',')','"',':','>','<','/','|','{','^');

    $titleNoChr = str_replace($WrongChar, '', $title);
    $titleSEO = str_replace(' ', '-', $titleNoChr);
    return $titleSEO;
}


function print_number_count($number) {
    $units = array( '', 'K', 'M', 'B');
    $power = $number > 0 ? floor(log($number, 1000)) : 0;
    if($power > 0)
        return @number_format($number / pow(1000, $power), 2, ',', ' ').' '.$units[$power];
    else
        return @number_format($number / pow(1000, $power), 0, '', '');
}


