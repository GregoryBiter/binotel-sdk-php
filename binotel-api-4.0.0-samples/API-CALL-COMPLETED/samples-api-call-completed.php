<?php

/**
 * API CALL COMPLETED.
 * Документация: http://developers.binotel.ua/#api-call-completed
 */


/**
 * Пример логирования POST данных, отправляемых Вашему скрипту при завершении звонка в АТС Binotel.
 */
$content = sprintf('[%s] Received new POST data!%s', date('r'), PHP_EOL);
$content .= var_export($_POST, TRUE) . PHP_EOL . PHP_EOL . PHP_EOL;
file_put_contents(sprintf('%s/api-call-completed.log', __DIR__), $content, FILE_APPEND);
