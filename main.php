<?php
error_reporting(0);

require __DIR__ . '/config.php';
require __DIR__ . '/vendor/autoload.php';

use NanoTel\NanoTel;
use NanoTel\Event\Events;

$BOT_TOKEN = $BOT_CONFIG['BOT']['TOKEN'];
$BOT_NAME  = $BOT_CONFIG['BOT']['NAME'];

$nt = new NanoTel($BOT_TOKEN);
$event = Events::getEvents();

if (!Events::has("message")) {
    exit;
}

$text    = $event->message->text;
$chat_id = $event->message->chat->id;
$tc      = $event->message->chat->type;

function getAi($text)
{
    $api_url = "https://open.wiki-api.ir/apis-1/ChatGPT?q=" . urlencode($text);
    $ch = curl_init($api_url);

    curl_setopt_array($ch, [
        CURLOPT_HTTPGET        => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10
    ]);

    $response = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);

    if ($error || !$response) {
        return "*Error: Unable to connect to AI service.*";
    }

    $data = json_decode($response);
    return isset($data->results) ? $data->results : "*Error: Invalid response.*";
}

if ($text === "/start") {
    $message = "<b>Hello, welcome to {$BOT_NAME} bot</b>\n\n";
    $message .= ($tc === "private") ?
        "- Send your text to chat with AI:" :
        "- To chat with AI in a group, use the following command:\n<code>ai {text}</code>";

    $nt->sendMessage(
        chat_id: $chat_id,
        text: $message,
        parse_mode: "HTML"
    );
    exit;
}

if ($tc === "private") {
    $nt->sendMessage(
        chat_id: $chat_id,
        text: getAi($text),
        parse_mode: "Markdown"
    );
    exit;
}

if (in_array($tc, ['group', 'supergroup'], true) && preg_match('/^ai\s+(.+)$/s', $text, $matches)) {
    $nt->sendMessage(
        chat_id: $chat_id,
        text: getAi($matches[1]),
        parse_mode: "Markdown"
    );
}
