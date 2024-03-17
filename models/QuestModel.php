<?php
//---------- модель для работы с заданиями ----------
require_once '../database.php';

class QuestModel {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    //метод для создания нового задания
    public function createQuest($name, $cost, $custom) {
        //добавление задания в базу данных
        $sql = "INSERT INTO quests (name, cost, custom) VALUES (?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('sdi', $name, $cost, $custom);
        $stmt->execute();
        //возврат ID нового задания
        return $stmt->insert_id;
    }

    //метод для получения стоимости задания по его идентификатору
    public function getQuestCost($questId) {
        $sql = "SELECT cost FROM quests WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $questId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['cost'];
        } else {
            //если задание не найдено, то 0
            return 0;
        }
    }

    //метод для проверки существования задания по ID
    public function questExists($questId)
    {
        $sql = "SELECT COUNT(*) AS count FROM quests WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $questId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
