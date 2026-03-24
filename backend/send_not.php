<?php
require 'vendor/autoload.php';

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

/**
 * Send FCM push notifications to multiple users using the Firebase v1 API.
 *
 * @param array $tokens       Array of FCM tokens
 * @param string $title       Notification title
 * @param string $body        Notification body
 * @param string|null $image  (Optional) Image URL for the notification
 */
function sendFCMNotification(array $tokens, string $title, string $body, string $image = "/images/notif.png")
{
    // Load service account credentials
    $cred = new ServiceAccountCredentials(
        'https://www.googleapis.com/auth/firebase.messaging',
        json_decode(file_get_contents("vrinda-6abfa-firebase-adminsdk-fbsvc-083ff1866e.json"), true)
    );

    // Fetch access token
    $token = $cred->fetchAuthToken(HttpHandlerFactory::build());

    // FCM endpoint
    $fcmUrl = "https://fcm.googleapis.com/v1/projects/vrinda-6abfa/messages:send";

    foreach ($tokens as $deviceToken) {
        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body
                ],
                "webpush" => [
                    "fcm_options" => [
                        "link" => "google.com"
                    ]
                ]
            ]
        ];

        // Include image if provided
        if ($image) {
            $payload["message"]["notification"]["image"] = $image;
        }

        // Send the request
        $ch = curl_init($fcmUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token['access_token']
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "Error sending to $deviceToken: " . curl_error($ch) . "\n";
        } else {
            //echo "Response for $deviceToken: $response\n";
        }

        curl_close($ch);
    }
}
// sendFCMNotification(
//   [
//       "fDO1o0cRHl1m9X3rH5hEPf:APA91bEpD4b9g_78FscoWuMmTWubRPd2BmV39pMJXbNhzLbl6qfd6TFrLAoww1UGp2OfYFrjjdZ_8Q-ArT5vXcPCu6RWEtUY1HqhfkrKiZ0oIrB59eTBUdc",
//       "f9DA4K7xKrGqh6yBT-J0Be:APA91bHzwCVjGYLz6Sw7HOb_f-g8RhxDWH7WPYUHVSJQvu7Bk26z7U-p0tRTOYSaj7UA0fjuMW7UMO_sUzP31MIP68ITnaVYMnOnAwFmeWuvtDERVaejjiA"
//   ],
//   "🎉 New Update!",
//   "Check out the new features we just released!",
//   "https://emojiisland.com/cdn/shop/products/Ghost_Emoji_large.png?v=1571606037"
// );

?>