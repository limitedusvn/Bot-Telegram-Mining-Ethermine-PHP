<?php
// CONFIG BOT
define('token', '461268828:AAGhAxduZtKmyzpzgOLK-0ftuYvZzTOXecA');
$Severpool = ['ethermine' => 'https://api.ethermine.org/miner/', 'zcash' => 'https://api-zcash.flypool.org/miner/'];
$Ethermine_wallet = ['Vi001' => '0ec77154451dd411ce376e357fba18c7304xxx', //Chane TXT Wallet then received
];
$telegram_id = ['HideX' => - 1001156626149, //Chane Telegram then received
];
// FUNCTION

/**
 * [getTime_Ethermine description]
 * @param  [Int] $telegram_id [ID Telegram]
 * @return [Int] Time Sever API [Return Unix Time]
 */
function getTime_Ethermine($telegram_id) {
    $url = 'https://api.ethermine.org/servers/history';
    $get_content_url = file_get_contents($url);
    $content_json = json_decode($get_content_url, FALSE); //asia1:4024|eu1:4025|us1:4026|us2:4027
    $data = $content_json->data[4024]->time;
    if (empty($data)) {
        $send = sendMessage_Telegram($telegram_id, 'Sever Error');
        file_get_contents($send);
        exit();
    }
    return $data;
}
/**
 * [sendMessage_Telegram description]
 * @param  [Int] $user_id [ID Telegram to send message]
 * @param  [Str] $msg [Messages to send]
 * @return [Null]
 */
function sendMessage_Telegram($user_id, $msg) {
    $request_params = ['chat_id' => $user_id, 'text' => $msg];
    $request_url = 'https://api.telegram.org/bot' . token . '/sendMessage?' . http_build_query($request_params);
    file_get_contents($request_url);
    return null;
}
/**
 * [findName_Miner description]
 * @param  [Str] $Severpool     [description]
 * @param  [Int] $idMiner       [description]
 * @param  [Str] $addressWallet [description]
 * @return [Str] Name Miner
 */
function findName_Miner($Severpool, $idMiner, $addressWallet) {
    $id = $idMiner - 1;
    $url = $Severpool . $addressWallet . '/workers';
    $get_url = file_get_contents($url);
    $content_url = json_decode($get_url, FALSE);
    $nameMiner = $content_url->data[$id]->worker;
    return $nameMiner;
}
//FUNC ACTION
function checkMiner($Severpool, $addressWallet, $telegram_id) {
    $request_url = $Severpool . $addressWallet . '/workers';
    $get_content = file_get_contents($request_url);
    $content_json = json_decode($get_content, FALSE);
    $timeSever = getTime_Ethermine($telegram_id);
    $i = 1;
    foreach ($content_json->data as $data) {
        $lastSeen = $data->lastSeen;
        $checkOut = $timeSever - $lastSeen;
        if ($checkOut > 150 && $checkOut < 500 || $checkOut > 1500 && $checkOut < 10000) {
            $nameMiner = findName_Miner($Severpool, $i, $addressWallet);
            $msgout = 'Warning: [' . $nameMiner . '] no connection';
            sendMessage_Telegram($telegram_id, $msgout);
        }
        if ($checkOut > 10000 && $checkOut < $timeSever) {
            $nameMiner = findName_Miner($Severpool, $i, $addressWallet);
            $msgout = 'Warning: [' . $nameMiner . '] do not connect long time';
            sendMessage_Telegram($telegram_id, $msgout);
        }
        $i++;
    }
    return null;
}
// ACTION
checkMiner($Severpool['zcash'], $Ethermine_wallet['Vi001'], $telegram_id['HideX']);
checkMiner($Severpool['ethermine'], $Ethermine_wallet['Vi001'], $telegram_id['HideX']);
?>