<?php

/**
 * Created by PhpStorm.
 * User: ujjwal
 * Date: 12/6/17
 * Time: 8:17 PM
 */

namespace App\Helpers;


use OneSignal;

class PushNotificationHelper
{
    static function send($token, $title, $body, $data)
    {
        $data['title'] = $title;
        $data['body'] = $body;

        try {
            OneSignal::sendNotificationToUser(
                $title,
                $token,
                null,
                $data
            );
        } catch(\Exception $ex) {
            //
        }

        // $optionBuilder = new OptionsBuilder();
        // $optionBuilder->setTimeToLive(60*20);

        // $notificationBuilder = new PayloadNotificationBuilder($title);
        // $notificationBuilder->setBody($body)
        //     ->setSound('default');

        // $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData($data);

        // $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        // FCM::sendTo($token, $option, null, $data);
    }
}
