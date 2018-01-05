<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => 'AAAAlgAQujg:APA91bF07UfOa5kRARf09D_8XEPFAFmM3urbltO0hjSTRC-VQ2wFONpNgao3ILPg7nRNwG8uAIPTtJJNWs5Gw-O-f9pJ231xZrlgv3SHwFXkcKgK-KmLfMAyyycGMyJjKdBk-LSpr7iE',
        'sender_id' => '644246190648',
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
