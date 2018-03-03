<?php


//$serverKey = "AAAA5iND8kw:APA91bHi-BEKwta4GoKXSkqDRzX0HMwGLFuy4rthIgqwOgxwkd0qvxm2sL1KVumfyOewLpPWzbBSTeMTqIz0B5VqhAHkPcH98DEETAGhQjTrMz20odLbtyxlq7vfBECOtYxmQWV4JQde";
$serverKey = "AAAAj90cIes:APA91bHt6gptpgDPqDl6LXaTo1za3pd5bAFonrShKkClZfNvCyHZXT29VClrPlHvVy--IGsGFA3pIuDW1wQTjIacSiYX1f3qoG2jAcYECDgAfPeUNNGuxubz_plisA8cV5gW-XGpuh2W";


define("GOOGLE_SERVER_KEY", $serverKey);

function send_fcm_subComment($message, $id, $activity, $feedID, $commentID, $profileImageUrl, $emailCommentWriter)
{
    $url = 'https://fcm.googleapis.com/fcm/send';

    $headers = array(
        'Authorization: key=' . GOOGLE_SERVER_KEY,
        'Content-Type: application/json'
    );

    $fields = array(
        'data' => array(
            "message" => $message,
            "title" => '',
            "activity" => $activity,
            "feedID" => $feedID,
            "commentID" => $commentID,

            "profileImageUrl" => $profileImageUrl,

            "emailCommentWriter" => $emailCommentWriter


        ),

//        'notification' => array("body" => $message)
    );

    if (is_array($id)) {
        $fields['registration_ids'] = $id;
    } else {
        $fields['to'] = $id;
    }

    $fields['priority'] = "high";

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    if ($result === FALSE) {
//die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return 'result =' . $result;
}

?>