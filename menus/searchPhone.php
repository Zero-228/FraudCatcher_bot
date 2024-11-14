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
 * This file is part of FraudCatcher bot. The use of this file is governed by the
 * terms of the Simple Commercial License, which can be found in the LICENSE file
 * in the root directory of this project.
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../localization.php';
require_once __DIR__ . '/../functions.php';

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SearchPhoneMenu extends InlineMenu
{
    protected Nutgram $bot;
    protected string $phoneNum;
    protected string $reason = "";

    public function __construct(Nutgram $bot, $phoneNum)
    {
        parent::__construct();
        $this->bot = $bot;
        $this->phoneNum = $phoneNum;
    }

    public function start(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $msg = msg('searching_phone', $lang).$this->phoneNum;
        $this->clearButtons()->menuText($msg)
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@cancel'))
            ->showMenu();
        usleep(rand(150, 350)*10000);
        $phone = searchPhone($this->phoneNum);
        if ($phone == false) {
            createPhone($this->phoneNum);
            $phone = searchPhone($this->phoneNum);
        }
        $phoneNum = $phone['phoneNum'];
        $warns = getPhoneWarns($phoneNum);
        $searchs = getPhoneSearches($phoneNum);
        $status = "";
        if ($warns > 3 && $warns < 6 && $searchs > 10) {
            $status = "⚠️";
        } elseif ($warns > 5 && $warns < 11 && $searchs > 10) {
            $status = "❗️";
        } elseif ($warns > 10 && $searchs > 10) {
            $status = "‼️";
        } elseif($searchs < 11) {
            $status = "✅";
        } else {
            $status = "✅";
        }

        $phoneVars = [
            "{phoneNum}" => $phoneNum,
            "{searchs}" => $searchs,
            "{warns}" => $warns,
            "{status}" => $status,
        ];
        $this->clearButtons()->menuText(msg('phone_status', $lang, $phoneVars))
            ->addButtonRow(InlineKeyboardButton::make(msg('warn_phone', $lang), callback_data: '@getReason'))
            ->addButtonRow(InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@cancel'))
            ->orNext('none')
            ->showMenu();
    }

    protected function getReason(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $this->clearButtons()->menuText(msg('select_reason', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('spam', $lang), callback_data: 'spam@warnPhone'))
            ->addButtonRow(InlineKeyboardButton::make(msg('fraud', $lang), callback_data: 'fraud@warnPhone'))
            ->addButtonRow(InlineKeyboardButton::make(msg('other', $lang), callback_data: '@createReason'))
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
            ->orNext('none')
            ->showMenu();
    }

    protected function createReason(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $this->clearButtons()->menuText(msg('enter_reason', $lang))
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'))
            ->orNext('reasonCheck')
            ->showMenu();
    }

    protected function reasonCheck(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $this->reason = $bot->message()->text;
        $bot->deleteMessage($bot->userId(),$bot->messageId());
        $this->clearButtons()->menuText(msg('check_reason', $lang).$this->reason)
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@createReason'),InlineKeyboardButton::make(msg('confirm', $lang), callback_data: '@manualWarn'))
            ->orNext('reasonCheck')
            ->showMenu();
    }

    protected function manualWarn(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $msg = "";
        if (checkWarns($this->phoneNum, $bot->userId())) {
            warnPhone($this->phoneNum, $bot->userId(), $this->reason);
            $msg = msg('warn_successfull', $lang);
        } else {
            $msg = msg('warn_delay', $lang);
        }
        $this->clearButtons()->menuText($msg)
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'),InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@cancel'))
            ->orNext('none')
            ->showMenu();
    }

    protected function warnPhone(Nutgram $bot)
    {
        $lang = lang($bot->userId());
        $reason = $bot->callbackQuery()->data;
        $msg = "";
        if (checkWarns($this->phoneNum, $bot->userId())) {
            warnPhone($this->phoneNum, $bot->userId(), $reason);
            $msg = msg('warn_successfull', $lang);
        } else {
            $msg = msg('warn_delay', $lang);
        }
        $this->clearButtons()->menuText($msg)
            ->addButtonRow(InlineKeyboardButton::make(msg('back', $lang), callback_data: '@start'),InlineKeyboardButton::make(msg('cancel', $lang), callback_data: '@cancel'))
            ->orNext('none')
            ->showMenu();
    }

    protected function cancel(Nutgram $bot)
    {
        $bot->sendMessage(msg('canceled', lang($bot->userId())));
        $this->end();
    }

    public function none(Nutgram $bot)
    {
        $bot->sendMessage('Bye!');
        $this->end();
        error_log('Bye!');
    }
}
?>
