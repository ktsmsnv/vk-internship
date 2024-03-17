<?php
header('Content-Type: text/html; charset=UTF-8');

//---------- обработчик запроса на создание задания ----------

//модель для работы с заданиями
require_once '../models/QuestModel.php';

//данные из запроса
$name = $_POST['name'];
$cost = $_POST['cost'];
$custom = isset($_POST['custom']) ? ($_POST['custom'] === '1' ? 1 : 0) : 0;

//создание нового задания
$questModel = new QuestModel();
$questId = $questModel->createQuest($name, $cost, $custom);

//отправка ответа
echo json_encode(array('ID нового задания' => $questId), JSON_UNESCAPED_UNICODE);

