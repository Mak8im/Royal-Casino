<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Проверка заполнения всех полей
    if (empty($username) || empty($email) || empty($password)) {
        echo "Все поля обязательны для заполнения";
        exit;
    }
    
    // Проверка валидности email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Некорректный email адрес";
        exit;
    }
    
    // Хеширование пароля для безопасности
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Формирование строки для записи в файл
    $user_data = "Имя пользователя: $username | Email: $email | Пароль (хэш): $hashed_password | Дата регистрации: " . date('Y-m-d H:i:s') . PHP_EOL;
    
    // Запись данных в файл
    $file = 'users.txt';
    if (file_put_contents($file, $user_data, FILE_APPEND | LOCK_EX)) {
        echo "success";
    } else {
        echo "Ошибка при сохранении данных";
    }
} else {
    echo "Неверный метод запроса";
}
?>
