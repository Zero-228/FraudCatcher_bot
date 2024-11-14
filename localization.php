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

$languages = array(
	'en' => array(
		'welcome' => 'Greetengs',
		'welcome_back' => 'Welcome back to main menu',
		'change_language' => '🌐 Change language',
		'choose_language' => 'Choose language',
		'language_changed' => 'Language changed',
		'language' => '🇬🇧 English',
		'back' => "↩️ Back",
		'confirm' => 'Confirm ✅',
		'cancel' => 'Cancel ❌',
		'canceled' => '❌ Action canceled ',
		'searching_phone' => '🔎 Searching phone: ',
		'phone_status' => "📜    {status}    Information     {status}   📜\n==============================\n\n☎️ Phone number: {phoneNum}\n🔎 Searchs: {searchs}\n\n⚠️ Warns: {warns}\n\n=========================",
		'warn_phone' => 'Warn phone ⚠️',
		'dont_understand' => '😔 Sorry, i don\'t understand this command',
		'select_reason' => "📝 Select warn reason",
		'spam' => "Spam 🙉",
		'fraud' => "Fraud 🙈",
		'other' => "Other 🙊",
		'enter_reason' => "✏️ Enter warn weason",
		'check_reason' => "ℹ️ Your reason: \n",
		'warn_successfull' => "✅ You successfully warned other users!\nThank you for your cooperation!",
		'warn_delay' => "⚠️ You must wait at least 1 hour \nbefore warn this number again!",
		'help_info' => "ℹ️ This bot can find information about phone number you send to it, and check if other users warned that number already.\n\nJust send any phone number in the chat 😄",
	),
	'ru' => array(
		'welcome' => 'Добро пожаловать',
		'welcome_back' => 'С возвращением в главное меню',
		'change_language' => '🌐 Сменить язык',
		'choose_language' => 'Выберите язык',
		'language_changed' => 'Язык изменён',
		'language' => '🇷🇺 Русский',
		'back' => "↩️ Назад",
		'confirm' => 'Подтвердить ✅',
		'cancel' => 'Отменить ❌',
		'canceled' => '❌ Действие отменено ',
		'searching_phone' => '🔎 Ищем номер: ',
		'phone_status' => "📜    {status}    Информация     {status}   📜\n==============================\n\n☎️ Номер телефона: {phoneNum}\n🔎 Запросов: {searchs}\n\n⚠️ Жалоб: {warns}\n\n=========================",
		'warn_phone' => 'Пожаловаться ⚠️',
		'dont_understand' => '😔 Sorry, i don\'t understand this command',
		'dont_understand' => '😔 Sorry, i don\'t understand this command',
		'select_reason' => "📝 Выберите причину жалобы",
		'spam' => "Спам 🙉",
		'fraud' => "Мошенничество 🙈",
		'other' => "Другое 🙊",
		'enter_reason' => "✏️ Укажите причину жалобы",
		'check_reason' => "ℹ️ Ваша причина: \n",
		'warn_successfull' => "✅ Вы успешно предупредили других пользователей!\nБлагодарим за сотрудничество!",
		'warn_delay' => "⚠️ Вы должны подождать минимум 1 час\nпрежде чем снова жаловаться на этот номер!",
		'help_info' => "ℹ️ This bot can find information about phone number you send to it, and check if other users warned that number already.\n\nJust send any phone number in the chat 😄",
	),
	'uk' => array(
		'welcome' => 'Ласкаво просимо',
		'welcome_back' => 'З поверненням до головного меню',
		'change_language' => '🌐 Змiнити мову',
		'choose_language' => 'Оберiть мову',
		'language_changed' => 'Мову змiнено',
		'language' => '🇺🇦 Українська',
		'back' => "↩️ Назад",
		'confirm' => 'Пiдтвердити ✅',
		'cancel' => 'Вiдмiнити ❌',
		'canceled' => '❌ Дiя вiдмiнена ',
		'searching_phone' => '🔎 Шукаємо телефон: ',
		'phone_status' => "📜    {status}    Iнформацiя     {status}   📜\n==============================\n\n☎️ Номер телефону: {phoneNum}\n🔎 Запитiв: {searchs}\n\n⚠️ Скарг: {warns}\n\n=========================",
		'warn_phone' => 'Поскаржитися ⚠️',
		'dont_understand' => '😔 Sorry, i don\'t understand this command',
		'select_reason' => "📝 Выберiть причину скарги",
		'spam' => "Спам 🙉",
		'fraud' => "Шахрайство 🙈",
		'other' => "Iнше 🙊",
		'enter_reason' => "✏️ Укажiть причину скарги",
		'check_reason' => "ℹ️ Ваша причина: \n",
		'warn_successfull' => "✅ You successfully warned other users!\nThank you for your cooperation!",
		'warn_delay' => "⚠️ You must wait at least 1 hour \nbefore warn this number again!",
		'help_info' => "ℹ️ This bot can find information about phone number you send to it, and check if other users warned that number already.\n\nJust send any phone number in the chat 😄",
	),
);

function msg($message_key, $user_language, $variables = []) {
    global $languages;
    
    // 'en' - standart language
    if (!isset($languages[$user_language])) {$user_language = 'en';}

    $message = isset($languages[$user_language][$message_key]) ? $languages[$user_language][$message_key] : "Unknown key";

    // Replacing variables
    if (!empty($variables)) {$message = strtr($message, $variables);}

    return $message;
}

?>