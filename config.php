<?php
// Конфигурация базы данных
define('DB_FILE', 'users.db');
define('DB_DIR', __DIR__);

// Создание папки для базы данных если не существует
if (!file_exists(DB_DIR)) {
    mkdir(DB_DIR, 0755, true);
}

// Функция для получения всех пользователей
function getUsers() {
    if (!file_exists(DB_FILE)) {
        return [];
    }
    
    $data = file_get_contents(DB_FILE);
    return $data ? unserialize($data) : [];
}

// Функция для сохранения пользователей
function saveUsers($users) {
    return file_put_contents(DB_FILE, serialize($users));
}

// Функция для поиска пользователя по email
function findUserByEmail($email) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    return null;
}

// Функция для добавления пользователя
function addUser($userData) {
    $users = getUsers();
    
    // Проверяем, нет ли уже пользователя с таким email
    if (findUserByEmail($userData['email'])) {
        return false;
    }
    
    // Добавляем нового пользователя
    $users[] = $userData;
    return saveUsers($users);
}
?>
