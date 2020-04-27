<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'k6XjdQoa35aXYv4QBRQAwZ6NvEOSVXOaF4zYTbS9l6kfnVtFWOAPgwQh+3zYj/P3E9eA5jJ9O569Q0fdAolPDo9bKDBkhtMtcM3XHNazkfQ9kTqgPGirW1wIHXmwtnvXD0W2jBM1VgLOp/crbAmriwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			
			// Get text sent
			$text = $event['message']['text'];
			//$text = $event['source']['userId'];
			
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			/*$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];*/
			
			$data2 = {
  "type": "flex",
  "altText": "Flex Message",
  "contents": {
    "type": "bubble",
    "hero": {
      "type": "image",
      "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_5_carousel.png",
      "size": "full",
      "aspectRatio": "20:13",
      "aspectMode": "cover"
    },
    "body": {
      "type": "box",
      "layout": "vertical",
      "spacing": "sm",
      "contents": [
        {
          "type": "text",
          "text": "Arm Chair, White",
          "size": "xl",
          "weight": "bold",
          "wrap": true
        },
        {
          "type": "box",
          "layout": "baseline",
          "contents": [
            {
              "type": "text",
              "text": "$49",
              "flex": 0,
              "size": "xl",
              "weight": "bold",
              "wrap": true
            },
            {
              "type": "text",
              "text": ".99",
              "flex": 0,
              "size": "sm",
              "weight": "bold",
              "wrap": true
            }
          ]
        }
      ]
    },
    "footer": {
      "type": "box",
      "layout": "vertical",
      "spacing": "sm",
      "contents": [
        {
          "type": "button",
          "action": {
            "type": "uri",
            "label": "Add to Cart",
            "uri": "https://linecorp.com"
          },
          "style": "primary"
        },
        {
          "type": "button",
          "action": {
            "type": "uri",
            "label": "Add to whishlist",
            "uri": "https://linecorp.com"
          }
        }
      ]
    }
  }
};
			
			$post = $data2;
			//$post = json_encode($data2);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
