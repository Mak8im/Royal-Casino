<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Валидация
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['message'] = 'Все поля обязательны для заполнения';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit;
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['message'] = 'Пароли не совпадают';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = 'Некорректный email адрес';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit;
    }
    
    // Проверяем, нет ли уже пользователя с таким email
    if (findUserByEmail($email)) {
        $_SESSION['message'] = 'Пользователь с таким email уже зарегистрирован';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit;
    }
    
    // Создаем нового пользователя
    $userData = [
        'id' => uniqid(),
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'balance' => 10000,
        'registration_date' => date('Y-m-d H:i:s')
    ];
    
    if (addUser($userData)) {
        $_SESSION['message'] = 'Регистрация успешна! Добро пожаловать в казино!';
        $_SESSION['message_type'] = 'success';
        
        // Автоматически входим после регистрации
        $_SESSION['user'] = [
            'id' => $userData['id'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'balance' => $userData['balance']
        ];
    } else {
        $_SESSION['message'] = 'Ошибка при регистрации. Попробуйте еще раз.';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: index.php');
    exit;
}
?>
