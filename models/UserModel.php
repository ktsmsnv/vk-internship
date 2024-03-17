<?php
//---------- модель для работы с пользователями ----------
require_once '../database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    //метод для создания нового пользователя
    public function createUser($name) {
        //добавление нового пользователя в базу данных
        $sql = "INSERT INTO users (name) VALUES (?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        //возврат ID нового пользователя
        return $stmt->insert_id;
    }

    //метод для получения баланса пользователя
    public function getUserBalance($userId) {
        //проверка существования пользователя
        $userModel = new UserModel();
        if (!$userModel->userExists($userId)) {
            return "Пользователь с ID $userId не существует";
        }
        //получение баланса пользователя из базы данных
        $sql = "SELECT balance FROM users WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        //возврат баланса пользователя
        return $result['balance'];
    }

    //метод для увеличения баланса пользователя
    public function increaseUserBalance($userId, $amount) {
        $sql = "UPDATE users SET balance = balance + ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('di', $amount, $userId);
        $stmt->execute();
    }

    //метод для проверки существования пользователя по ID
    public function userExists($userId)
    {
        $sql = "SELECT COUNT(*) AS count FROM users WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
