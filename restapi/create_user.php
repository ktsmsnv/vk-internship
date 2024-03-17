<?php
header('Content-Type: text/html; charset=UTF-8');

//---------- обработчик запроса на создание пользователя ----------

//модель для работы с пользователями
require_once '../models/UserModel.php';

//данные из запроса
$name = $_POST['name'];

//создание нового пользователя
$userModel = new UserModel();
$userId = $userModel->createUser($name);

//отправка ответа
echo json_encode(array('ID нового пользователя' => $userId), JSON_UNESCAPED_UNICODE);

