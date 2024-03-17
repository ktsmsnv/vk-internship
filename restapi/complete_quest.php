<?php
header('Content-Type: text/html; charset=UTF-8');

//---------- обработчик  запроса на отметку выполнения задания ----------

//модель для работы с выполненными заданиями
require_once '../models/CompletedQuestModel.php';

//данные из запроса
$userId = $_POST['user_id'];
$questId = $_POST['quest_id'];

//отметка задания как выполненное для пользователя
$completedQuestModel = new CompletedQuestModel();
$result = $completedQuestModel->completeQuest($userId, $questId);

//проверяем результат выполнения
if ($result === true) {
    echo json_encode(array('message' => 'Задание успешно выполнено!'), JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array('error' => $result), JSON_UNESCAPED_UNICODE);
}
