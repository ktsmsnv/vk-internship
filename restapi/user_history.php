<?php
header('Content-Type: text/html; charset=UTF-8');

//---------- обработчик запроса на получение истории выполненных заданий и баланса пользователя ----------

//модель для работы с выполненными заданиями
require_once '../models/CompletedQuestModel.php';
//модель для работы с пользователями
require_once '../models/UserModel.php';

//данные из запроса
$userId = $_GET['user_id'];


//история выполненных заданий для пользователя
$completedQuestModel = new CompletedQuestModel();
$userQuests = $completedQuestModel->getUserCompletedQuests($userId);

//баланс пользователя
$userModel = new UserModel();
$userBalance = $userModel->getUserBalance($userId);

//проверяем результат выполнения
if ($userBalance !== false) {
    echo json_encode(array('ID пользователя' => $userId, 'ID Выполненных заданий' => $userQuests, 'Баланс' => $userBalance), JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array('error' => "Ошибка при получении баланса пользователя"), JSON_UNESCAPED_UNICODE);
}