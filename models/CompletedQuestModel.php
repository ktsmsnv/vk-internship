<?php
//---------- модель для работы с выполненными заданиями ----------
require_once '../database.php';
//модель для работы с заданиями
require_once '../models/QuestModel.php';
//модель для работы с пользователями
require_once '../models/UserModel.php';

class CompletedQuestModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    //метод для отметки задания как выполненного
    public function completeQuest($userId, $questId)
    {
        //проверка существования пользователя
        $userModel = new UserModel();
        if (!$userModel->userExists($userId)) {
            return "Пользователь с ID $userId не существует";
        }

        //проверка существования задания и получение поля custom
        $sql = "SELECT custom FROM quests WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $questId);
        $stmt->execute();
        $result = $stmt->get_result();

        //проверка наличия задания
        if ($result->num_rows == 0) {
            return "Задание с ID $questId не существует";
        }

        //значение поля custom (1-многоразовое, 0-немногоразовое)
        $row = $result->fetch_assoc();
        $questCustom = $row['custom'];

        //проверка выполнения задания ранее, если задание не многоразовое
        if ($questCustom == false && $this->isQuestCompleted($userId, $questId)) {
            return "Задание уже было выполнено ранее!";
        }

        //если задание не было выполнено или является многоразовым, добавляем запись о выполненном задании в бд
        $sql = "INSERT INTO completed_quests (user_id, quest_id) VALUES (?, ?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('ii', $userId, $questId);
        $stmt->execute();

        //стоимость задания
        $questModel = new QuestModel();
        $questCost = $questModel->getQuestCost($questId);

        //увеличить баланс пользователя на стоимость выполненного задания
        $userModel->increaseUserBalance($userId, $questCost);

        return true;
    }

    //метод для проверки было ли выполнено задание пользователем ранее
    private function isQuestCompleted($userId, $questId)
    {
        $sql = "SELECT * FROM completed_quests WHERE user_id = ? AND quest_id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('ii', $userId, $questId);
        $stmt->execute();
        $result = $stmt->get_result();
        //если результат не пустой, значит задание уже выполнено
        return $result->num_rows > 0;
    }



    //метод для получения истории выполненных заданий для пользователя
    public function getUserCompletedQuests($userId)
    {
        //проверка существования пользователя
        $userModel = new UserModel();
        if (!$userModel->userExists($userId)) {
            return "Пользователь с ID $userId не существует";
        }

        //список выполненных заданий
        $completedQuests = array();

        //идентификаторы выполненных заданий для пользователя из бд
        $sql = "SELECT quest_id FROM completed_quests WHERE user_id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        //добавление идентификаторов выполненных заданий в массив
        while ($row = $result->fetch_assoc()) {
            $completedQuests[] = $row['quest_id'];
        }

        return $completedQuests;
    }
}
