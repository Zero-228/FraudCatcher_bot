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
		'welcome' => "🎉Welcome! \nYou have successfully registered \nin our bot for checking phone \nnumbers for fraud and spam. \n\nTo get started, simply send a \nphone number with the country \ncode in the chat and ensure your \ncontacts safety.",
		'welcome_back' => "🎉 Welcome! \n\nTo start checking number, \njust send it in the chat.",
		'change_language' => '🌐 Change language',
		'choose_language' => 'Choose language',
		'language_changed' => "🇬🇧 Language changed. \n\nSend /start to continue.",
		'language' => '🇬🇧 English',
		'back' => "↩️ Back",
		'confirm' => 'Confirm ✅',
		'cancel' => 'Cancel ❌',
		'canceled' => '❌ Action canceled ',
		'searching_phone' => '🔎 Searching phone: ',
		'phone_status' => "📜    {status}    Information     {status}   📜\n==============================\n\n☎️ Phone number: \n       {phoneNum}\n\n🔎 Searchs: {searchs}\n\n⚠️ Warns: {warns}\n\n=========================",
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
		'help_info' => "ℹ️ This bot can find information about \nphone number you send to it, and \ncheck if other users warned that \nnumber already.\n\nJust send any phone number with \nthe country code in the chat 😄\n\nExamples:\n   +1234567890\n   +1 234 567 890\n   +1 (234) 567-8900",
	),
	'ru' => array(
		'welcome' => "🎉 Добро пожаловать! \nВы успешно зарегистрировались в \nнашем боте для проверки телефонных \nномеров на мошенничество и спам. \nДля начала работы просто отправьте \nномер телефона с кодом страны \nв чат и убедитесь в безопасности \nваших контактов.",
		'welcome_back' => "🎉 Добро пожаловать! \n\nЧтобы начать проверку номера, \nпросто отправьте его в чат.",
		'change_language' => '🌐 Сменить язык',
		'choose_language' => 'Выберите язык',
		'language_changed' => "🇷🇺 Язык изменён. \n\nОтправь /start чтобы продолжить.",
		'language' => '🇷🇺 Русский',
		'back' => "↩️ Назад",
		'confirm' => 'Подтвердить ✅',
		'cancel' => 'Отменить ❌',
		'canceled' => '❌ Действие отменено ',
		'searching_phone' => '🔎 Ищем номер: ',
		'phone_status' => "📜    {status}    Информация     {status}   📜\n==============================\n\n☎️ Номер телефона: \n       {phoneNum}\n\n🔎 Запросов: {searchs}\n\n⚠️ Жалоб: {warns}\n\n=========================",
		'warn_phone' => 'Пожаловаться ⚠️',
		'dont_understand' => '😔 Извините, я не понимаю эту команду',
		'select_reason' => "📝 Выберите причину жалобы",
		'spam' => "Спам 🙉",
		'fraud' => "Мошенничество 🙈",
		'other' => "Другое 🙊",
		'enter_reason' => "✏️ Укажите причину жалобы",
		'check_reason' => "ℹ️ Ваша причина: \n",
		'warn_successfull' => "✅ Вы успешно предупредили других пользователей!\nБлагодарим за сотрудничество!",
		'warn_delay' => "⚠️ Вы должны подождать минимум 1 час\nпрежде чем снова жаловаться на этот номер!",
		'help_info' => "ℹ️ Этот бот может найти информацию \nпро номер телефона который ему \nотправят, и проверять жаловались \nли на него другие пользователи.\n\nПросто отправь любой телефонный \nномер с кодом страны в чат 😄\n\Примеры:\n   +1234567890\n   +1 234 567 890\n   +1 (234) 567-8900",
	),
	'uk' => array(
		'welcome' => "🎉 Ласкаво просимо! \nВи успішно зареєструвалися в нашому \nботі для перевірки телефонних \nномерів на шахрайство та спам. \nДля початку роботи просто надішліть \nномер телефону з кодом страни в чат і переконайтеся \nу безпеці ваших контактів.",
		'welcome_back' => "🎉 Ласкаво просимо! \n\nЩоб почати перевірку номерa, \nпросто надішліть його в чат.",
		'change_language' => '🌐 Змiнити мову',
		'choose_language' => 'Оберiть мову',
		'language_changed' => "🇺🇦 Мову змiнено. \n\nНадiшли /start щоб продовжити.",
		'language' => '🇺🇦 Українська',
		'back' => "↩️ Назад",
		'confirm' => 'Пiдтвердити ✅',
		'cancel' => 'Вiдмiнити ❌',
		'canceled' => '❌ Дiя вiдмiнена ',
		'searching_phone' => '🔎 Шукаємо телефон: ',
		'phone_status' => "📜    {status}    Iнформацiя     {status}   📜\n==============================\n\n☎️ Номер телефону: \n       {phoneNum}\n\n🔎 Запитiв: {searchs}\n\n⚠️ Скарг: {warns}\n\n=========================",
		'warn_phone' => 'Поскаржитися ⚠️',
		'dont_understand' => '😔 Вибачайте, я не розумiю цю команду',
		'select_reason' => "📝 Оберiть причину скарги",
		'spam' => "Спам 🙉",
		'fraud' => "Шахрайство 🙈",
		'other' => "Iнше 🙊",
		'enter_reason' => "✏️ Укажiть причину скарги",
		'check_reason' => "ℹ️ Ваша причина: \n",
		'warn_successfull' => "✅ Ви успiшно попередили iнших користувачiв!\nДякуємо за спiвпрацю!",
		'warn_delay' => "⚠️ Ви повиннi зачекати мiнiмум 1 годину,\nперш нiж поскаржитися на цей номер знову!",
		'help_info' => "ℹ️ Цей бот може знайти інформацію про \nномер телефону, який ви надсилаєте \nйому, і перевірити, чи інші користувачі \nвже попереджали про цей номер. \n\nПросто надішли будь-який номер \nтелефону з кодом страни в чат 😄\n\nПриклади:\n   +1234567890\n   +1 234 567 890\n   +1 (234) 567-8900",
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