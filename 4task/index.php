<?php
// Установка параметров для подавления вывода ошибок.
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Определение кодировки и типа контента.
header('Content-Type: text/html; charset=UTF-8');

// Функция для проверки данных на соответствие регулярному выражению.
function validateData($data, $pattern) {
    return preg_match($pattern, $data);
}

// Функция для отображения сообщения об ошибке.
function displayError($error) {
    print('<div class="error">' . $error . '</div>');
}

// Проверка метода запроса.
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

    // Проверка наличия кук с признаками ошибок.
    $errors = array();
    $errors['names'] = !empty($_COOKIE['names_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['languages'] = !empty($_COOKIE['languages_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['agree'] = !empty($_COOKIE['agree_error']);

    // Проверка наличия кук с ранее введенными значениями полей.
    $values = array();
    $values['names'] = empty($_COOKIE['names_value']) ? '' : $_COOKIE['names_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['languages'] = empty($_COOKIE['languages_value']) ? '' : $_COOKIE['languages_value'];
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];

    // Включаем содержимое файла формы.
    include('form.html');
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Блок обработки POST запроса.

    // Проверка заполнения обязательных полей и установка кук с признаками ошибок.
    $errors = FALSE;

    // Проверка поля "ФИО".
    if (empty($_POST['names'])  !validateData($_POST['names'], '/^[a-zA-Zа-яА-Я\s]{1,150}$/')) {
        setcookie('names_error', '1');
        $errors = TRUE;
    } else {
        setcookie('names_value', $_POST['names'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

    // Проверка поля "Телефон".
    if (empty($_POST['phone'])  !validateData($_POST['phone'], '/^\+?\d{1,15}$/')) {
        setcookie('phone_error', '1');
        $errors = TRUE;
    } else {
        setcookie('phone_value', $_POST['phone'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

        // Проверка поля "Email".
    if (empty($_POST['email'])  !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      setcookie('email_error', '1');
      $errors = TRUE;
    } else {
      setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

    // Проверка поля "Дата рождения".
    if (empty($_POST['date'])  !validateData($_POST['date'], '/^\d{4}-\d{2}-\d{2}$/')) {
      setcookie('date_error', '1');
      $errors = TRUE;
    } else {
      setcookie('date_value', $_POST['date'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }
// Проверка поля "Пол".
    if (empty($_POST['gender'])) {
      setcookie('gender_error', '1');
      $errors = TRUE;
    } else {
      setcookie('gender_value', $_POST['gender'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

    // Проверка поля "Любимые языки программирования".
    if (empty($_POST['Languages'])) {
      setcookie('languages_error', '1');
      $errors = TRUE;
    } else {
      // Формируем строку из выбранных языков для сохранения в куки.
      $languages_value = implode(',', $_POST['Languages']);
      setcookie('languages_value', $languages_value, time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

    // Проверка поля "Биография".
    if (empty($_POST['biography']) || !validateData($_POST['biography'], '/^[a-zA-Zа-яА-Яе0-9,.!? ]+$/')) {
      setcookie('biography_error', '1');
      $errors = TRUE;
    } else {
      setcookie('biography_value', $_POST['biography'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

    // Проверка поля "Согласие с условиями".
    if (empty($_POST['agree'])) {
      setcookie('agree_error', '1');
      $errors = TRUE;
    } else {
      setcookie('agree_value', $_POST['agree'], time() + 365 * 24 * 60 * 60); // Сохранение значения поля на год.
    }

    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    }

    // Удаляем куки с признаками ошибок после успешной валидации.
    setcookie('names_error', '', 100000);
    setcookie('phone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('date_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('languages_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('agree_error', '', 100000);

    $user = 'u67419';
    $pass = '8693464';
    $db = new PDO('mysql:host=localhost;dbname=u67419', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($_POST['languages'] as $language) {
        $stmt = $db->prepare("SELECT id FROM languages WHERE id= :id");
        $stmt->bindParam(':id', $language);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
          print('Ошибка при добавлении языка.<br/>');
          exit();
        }
    }

    try {
        $stmt = $db->prepare("INSERT INTO application (names,phones,email,dates,gender,biography)" . "VALUES (:names,:phone,:email,:date,:gender,:biography)");
        $stmt->execute(array('names' => $names, 'phone' => $phone, 'email' => $email, 'date' => $date, 'gender' => $gender, 'biography' => $biography));
        $applicationId = $db->lastInsertId();
      
        foreach ($_POST['Languages'] as $language) {
            $stmt = $db->prepare("SELECT id FROM languages WHERE title = :title");
            $stmt->bindParam(':title', $language);
            $stmt->execute();
            $languageRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($languageRow) {
                $languageId = $languageRow['id'];
        
                $stmt = $db->prepare("INSERT INTO application_languages (id_lang, id_app) VALUES (:languageId, :applicationId)");
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
