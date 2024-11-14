<?php 
/**
 * FraudCatcher bot
 * 
 * Licensed under the Simple Commercial License.
 * 
 * Copyright (c) 2024 Nikita Shkilov nikshkilov@yahoo.com
 * 
 * All rights reserved.
 * 
 * This file is part of this bot. The use of this file is governed by the
 * terms of the Simple Commercial License, which can be found in the LICENSE file
 * in the root directory of FraudCatcher project.
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'localization.php';
foreach (glob("menus/*.php") as $filename)
{
    require $filename;
}

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Support\DeepLink;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

$filesystemAdapter = new FilesystemAdapter();
$cache = new Psr16Cache($filesystemAdapter);
$bot = new Nutgram(BOT_TOKEN, new Configuration(cache: $cache));
$bot->setRunningMode(Webhook::class);
$bot->setWebhook(WEBHOOK_URL);

$data = file_get_contents('php://input');
writeLogFile($data, true);

$bot->onCommand('start', function(Nutgram $bot) {
    if (checkUser($bot->userId()) == 'no_such_user') {
        $user_info = get_object_vars($bot->user());
        createUser($user_info);
        createLog(TIME_NOW, 'user', $bot->userId(), 'registering', '/start');
        $inlineKeyboard = InlineKeyboardMarkup::make()
        ->addRow(InlineKeyboardButton::make(msg('change_language', lang($bot->userId())), null, null, 'callback_change_lang'));
        $bot->sendMessage(msg('welcome', lang($bot->userId())), reply_markup: $inlineKeyboard);
    } elseif (checkUser($bot->userId()) == 'one_user') {
        createLog(TIME_NOW, 'user', $bot->userId(), 'command', '/start');
        $inlineKeyboard = InlineKeyboardMarkup::make()
        ->addRow(InlineKeyboardButton::make(msg('change_language', lang($bot->userId())), null, null, 'callback_change_lang'));
        $bot->sendMessage(msg('welcome_back', lang($bot->userId())), reply_markup: $inlineKeyboard);
    } else {
        $bot->sendMessage('WTF are you?');
    }
});

$bot->onCommand('help', function(Nutgram $bot) {
    $bot->deleteMessage($bot->userId(),$bot->messageId());
    $role = checkRole($bot->userId());
    createLog(TIME_NOW, $role, $bot->userId(), 'command', '/help');
    $bot->sendMessage(msg('help_info', lang($bot->userId())));
});

$bot->onCommand('support', function(Nutgram $bot) {
    $bot->deleteMessage($bot->userId(),$bot->messageId());
    $role = checkRole($bot->userId());
    createLog(TIME_NOW, $role, $bot->userId(), 'command', '/support');
    $supportMenu = new SupportMenu($bot);
    $supportMenu->start($bot);
});

$bot->onCallbackQueryData('callback_change_lang', function (Nutgram $bot) {
    createLog(TIME_NOW, 'user', $bot->userId(), 'callback', 'change language');
    $languageMenu = new LanguageMenu($bot);
    $languageMenu->start($bot);
    $bot->answerCallbackQuery();
});

$bot->onCallbackQueryData('callback_cancel', function (Nutgram $bot) {
    $role = checkRole($bot->userId());
    if (checkUserStatus($bot->userId() == 'deleted')) {
        userActivatedBot($bot->userId());
    }
    createLog(TIME_NOW, $role, $bot->userId(), 'callback', 'cancel');
    try {
        $bot->deleteMessage($bot->userId(),$bot->messageId());
    } catch (Exception $e) {
        error_log($e);
    }
    $bot->sendMessage(msg('canceled', lang($bot->userId())));
    $bot->answerCallbackQuery();
});

$bot->onMessage(function (Nutgram $bot) {
    $lang = lang($bot->userId());
    $role = checkRole($bot->userId());
    $text = $bot->message()->text;
    $phoneNum = extractPhoneNumber($text);
    if ($phoneNum != false) {
        $bot->deleteMessage($bot->userId(),$bot->messageId());
        $searchPhoneMenu = new SearchPhoneMenu($bot, $phoneNum);
        $searchPhoneMenu->start($bot);
        createLog(TIME_NOW, $role, $bot->userId(), 'search', $phoneNum);
    } else { 
        createLog(TIME_NOW, 'user', $bot->userId(), 'message', $bot->message()->text);
        $bot->sendMessage(msg('dont_understand', $lang));
    }
});

$bot->run();

?>
