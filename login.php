<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Валидация
    if (empty($email) || empty($password)) {
        $_SESSION['message'] = 'Все поля обязательны для заполнения';
        $_SESSION['message_type'] = 'error';
        header('Location: index.php');
        exit;
    }
    
    // Ищем пользователя
    $user = findUserByEmail($email);
    
    if ($user && password_verify($password, $user['password'])) {
        // Успешный вход
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'balance' => $user['balance']
        ];
        
        $_SESSION['message'] = 'Добро пожаловать, ' . $user['username'] . '!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Неверный email или пароль';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: index.php');
    exit;
}
?>
