<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
header('Content-Type: text/html; charset=UTF-8');

function validateData($data, $pattern) {
    return preg_match($pattern, $data);
}

function displayError($error) {
    print('<div class="error">' . $error . '</div>');
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Блок обработки GET запроса.

    // Массив для временного хранения сообщений пользователю.
    $messages = array();

    // Проверка наличия куки с признаком успешного сохранения.
    if (!empty($_COOKIE['save'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('save', '', time() - 3600);
        // Если есть параметр save, то выводим сообщение пользователю.
        $messages[] = 'Спасибо, результаты сохранены.';
    }
    $errors = array();

    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['Languages[]'] = !empty($_COOKIE['Languages[]_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['agree'] = !empty($_COOKIE['agree_error']);

    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['Languages[]'] = empty($_COOKIE['Languages[]_value']) ? '' : $_COOKIE['Languages[]_value'];
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];

    include('form.html');
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = FALSE;

    if (empty($_POST['name']) || !validateData($_POST['name'], '/^[a-zA-Zа-яА-Я\s]{1,150}$/')) {
        setcookie('name_error', '1');
        $errors = TRUE;
    } 

    if (empty($_POST['phone']) || !validateData($_POST['phone'], '/^\+?\d{1,15}$/')) {
        setcookie('phone_error', '1');
        $errors = TRUE;
    } 

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1');
        $errors = TRUE;
      } 

      if (empty($_POST['date']) || !validateData($_POST['date'], '/^\d{4}-\d{2}-\d{2}$/')) {
        setcookie('date_error', '1');
        $errors = TRUE;
      } 

      if (empty($_POST['gender'])) {
        setcookie('gender_error', '1');
        $errors = TRUE;
      } 

      if (empty($_POST['Languages[]'])) {
        setcookie('Languages[]_error', '1');
        $errors = TRUE;
      } 

      if (empty($_POST['biography']) || !validateData($_POST['biography'], '/^[a-zA-Zа-яА-Яе0-9,.!? ]+$/')) {
        setcookie('biography_error', '1');
        $errors = TRUE;
      } 

      if (empty($_POST['agree'])) {
        setcookie('agree_error', '1');
        $errors = TRUE;
      } 

      if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    }

    setcookie('name_error', '', 100000);
    setcookie('phone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('Languages[]_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('agree_error', '', 100000);

    $user = 'u67438';
    $pass = '9231297';
    $db = new PDO('mysql:host=localhost;dbname=u67438', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($_POST['Languages[]'] as $language) {
        $stmt = $db->prepare("SELECT id FROM Languages[] WHERE id= :id");
        $stmt->bindParam(':id', $language);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
          print('Ошибка при добавлении языка.<br/>');
          exit();
        }
    }
    try {
        $stmt = $db->prepare("INSERT INTO application (name,phone,email,dates,gender,biography)" . "VALUES (:name,:phone,:email,:date,:gender,:biography)");
        $stmt->execute(array('name' => $name, 'phone' => $phone, 'email' => $email, 'date' => $date, 'gender' => $gender, 'biography' => $biography));
        $applicationId = $db->lastInsertId();

        foreach ($_POST['Languages[]'] as $language) {
            $stmt = $db->prepare("SELECT id FROM Languages[] WHERE title = :title");
            $stmt->bindParam(':title', $language);
            $stmt->execute();
            $languageRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($languageRow) {
                $languageId = $languageRow['id'];
        
                $stmt = $db->prepare("INSERT INTO application_Languages[] (id_lang, id_app) VALUES (:languageId, :applicationId)");
                $stmt->bindParam(':languageId', $languageId);
                $stmt->bindParam(':applicationId', $applicationId);
                $stmt->execute();
            } else {
                print('Ошибка: Не удалось найти ID для языка программирования: ' . $language . '<br/>');
                exit();
            }
        }
        print('Спасибо, форма сохранена.');
    }

    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }


    // Установка куки с признаком успешного сохранения.
    setcookie('save', '1', time() + 24 * 60 * 60);

    // Перенаправление на страницу с формой для отображения сообщения об успешном сохранении.
    header('Location: index.php');
}
?>
