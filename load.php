<?php

    require_once 'config.php';
    require_once __DIR__ . '/vendor/autoload.php';

    $googleAccountKeyFilePath = __DIR__ . '/secret.json';
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();

    $client->addScope('https://www.googleapis.com/auth/spreadsheets');

    $service = new Google_Service_Sheets($client);

    $spreadsheetId = '11z2N2L2M8Q3s2y417WTlmPXRqjHSsbVw4pvinex-JVw';

    $response = $service->spreadsheets->get($spreadsheetId);

    $values = [];

    // Получаем данные из БД
    $mysqli = new mysqli($host, $user, $password, $database);

    if ($mysqli->connect_errno) {
        echo ('<div class="alert alert-danger " role="alert">
                 '."Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error.'
                </div>');
        exit();
    }
    $mysqli->real_query("SELECT * FROM users WHERE age>=18");
    $res = $mysqli->use_result();

    while ($row = $res->fetch_assoc()) {
        array_push($values, [$row['name'], $row['fullname'], $row['age']]);
    }

    // Очистка таблицы
    $clear = new Google_Service_Sheets_ClearValuesRequest();
    $response = $service->spreadsheets_values->clear($spreadsheetId, 'list!A2:C1000', $clear);

    // Заполнение таблицы
    $ValueRange = new Google_Service_Sheets_ValueRange();
    $ValueRange->setValues($values);
    $options = ['valueInputOption' => 'USER_ENTERED'];
    $service->spreadsheets_values->update($spreadsheetId, 'list!A2', $ValueRange, $options);

    echo('<div class="alert alert-success" role="alert">Выгрузка прошла успешно</div>');
?>