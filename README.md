<h1>
  <strong>
     Профильное задание VK на стажировку "Программист разработчик"
  </strong>
</h1>

>    Код реализован на PHP

---

> <strong><h2>Как запустить код, проверить работу:</h2></strong>
> <p><strong>ВАРИАНТ 1:</strong> Проверить работу REST API сервиса можно поссылке через форму: <a href="w95094b7.beget.tech">http://w95094b7.beget.tech/</a></p>
> <p><strong>ВАРИАНТ 2:</strong> Проверить работу REST API сервиса можно развернув сервер.Нужно создать проект из данного репозитория и загрузить базу данных на сервер через панель управления. Файл базы данных вложен ниже:</p>
[ -> БАЗА ДАННЫХ ](https://github.com/ktsmsnv/vk-internship/blob/1330565b21d912b183af0ed51c0597549dd4e93c/vk_restapi.sql)

---

<ol>
  <li>
    <strong>
       Сущности:
    </strong>
    <br />
     - Две основные сущности: Пользователь (User) и Задание (Quest).
    <br />
     - Каждый пользователь характеризуется уникальным идентификатором (id), именем (name) и балансом (balance).
    <br />
     - Каждое задание также имеет уникальный идентификатор (id), название (name),стоимость (cost) и многоразовость (custom).
    <br />
     - Пользователь может выполнять задания, и каждое задание может быть выполнено только один раз, за исключением многоразовых заданий.
  </li>
  <li>
    <strong>
       API методы:
    </strong>
    <br />
     - метод создания пользователя,
    <br />
     - метод создания задания,
    <br />
     - метод, который сигнализирует сервису, что произошло некоторое событие, пользователь выполнил условие и задание можно посчитать выполненным и начислить награду пользователю (в параметрах user_id и quest_id, который выполнил пользователь),
    <br />
     - метод, который возвращает историю выполненных пользователем заданий и его баланс.
  </li>
  <li>
    <strong>
       База данных:
    </strong>
    <br />
     - Данные хранятся в реляционной базе данных MySQL.
    <br />
     - Существующие таблицы:
    <br><br />
          <ol>
          <li>Таблица completed_quests :</li>
            <ul>
              <li>id: Уникальный идентификатор выполненного задания (автоинкрементируемый).</li>
              <li>user_id: Идентификатор пользователя, который выполнил задание.</li>
              <li>quest_id: Идентификатор выполненного задания.</li>
              <li>completed_at: Дата и время завершения выполнения задания.</li>
             </ul>
              Эта таблица используется для отслеживания выполненных заданий пользователями. 
        <li>Таблица quests :</li>
         <ul>
          <li>id: Уникальный идентификатор задания (автоинкрементируемый).</li>
          <li>name: Название задания.</li>
          <li>cost: Стоимость задания.</li>
          <li>custom: Флаг, указывающий, является ли задание многоразовым (1 - да, 0 - нет).</li>
          </ul>
          В этой таблице хранятся все доступные задания.
          <li>Таблица users :</li>
          <ul>
          <li>id: Уникальный идентификатор пользователя (автоинкрементируемый).</li>
          <li>name: Имя пользователя.</li>
          <li>balance: Баланс пользователя.
          </ul>
          Эта таблица содержит информацию о пользователях и их текущем балансе.
          </ol>
  </li>
</ol>

---

<h3>Структура проекта и логика работы методов и моделей:</h3>
<ol>
  <li>
    <strong>
       restapi/create_user.php:
    </strong>
    <br />
     - Получаем данные из запроса, в данном случае, имя пользователя.
    <br />
     - Создаем новую запись в таблице пользователей (Users) с указанным именем и начальным балансом.
    <br />
     - Возвращаем ID нового пользователя в качестве ответа на запрос.
  </li>
  <li>
    <strong>
       restapi/create_quest.php:
    </strong>
    <br />
     - Получаем данные из запроса, такие как название задания, его стоимость и признак многоразовости.
    <br />
     - Добавляем новую запись в таблицу заданий (Quests) с указанными данными.
    <br />
     - Возвращаем ID нового задания в качестве ответа на запрос.
  </li>
  <li>
    <strong>
       restapi/complete_quest.php:
    </strong>
    <br />
     - Получаем данные из запроса, такие как ID пользователя и ID задания, которое он выполнил.
    <br />
     - Проверяем существование пользователя и задания в соответствующих таблицах.
    <br />
     - Проверяем, было ли задание выполнено ранее (если оно не многоразовое).
    <br />
     - Добавляем запись о выполненном задании в таблицу отслеживания выполненных заданий (CompletedQuests).
    <br />
     - Увеличиваем баланс пользователя на стоимость выполненного задания.
    <br />
     - Возвращаем сообщение об успешном выполнении задания или ошибку, если что-то пошло не так.
  </li>
  <li>
    <strong>
       restapi/user_history.php:
    </strong>
    <br />
     - Получаем ID пользователя из запроса.
    <br />
     - Получаем историю выполненных заданий пользователя из таблицы отслеживания выполненных заданий (CompletedQuests).
    <br />
     - Получаем текущий баланс пользователя из таблицы пользователей (Users).
    <br />
     - Формируем историю выполненных заданий и текущий баланс пользователя в виде JSON-ответа.
  </li>
  <li>
    <strong>
       database.php:
    </strong>
    <br />
     - Этот файл содержит класс для подключения к базе данных MySQL.
  </li>
  <li>
    <strong>
       index.php:
    </strong>
    <br />
     - Это основная страница, где пользователь может взаимодействовать с REST API через формы.
    <br />
     - На странице присутствуют формы для создания пользователя, создания задания, выполнения задания и просмотра истории пользователя.
    <br />
     - При отправке данных формы, данные передаются в соответствующий обработчик REST API, который выполняет соответствующую логику.
  </li>
  <li>
    <strong>
       models/UserModel.php:
    </strong>
    <br />
     - createUser($name): Метод для создания нового пользователя.
    <br />
     - getUserBalance($userId): Метод для получения баланса пользователя.
    <br />
     - increaseUserBalance($userId, $amount): Метод для увеличения баланса пользователя.
    <br />
     - userExists($userId): Метод для проверки существования пользователя.
  </li>
  <li>
    <strong>
       models/QuestModel.php:
    </strong>
    <br />
     - createQuest($name, $cost, $custom): Метод для создания нового задания.
    <br />
     - getQuestCost($questId): Метод для получения стоимости задания.
    <br />
     - questExists($questId): Метод для проверки существования задания.
  </li>
  <li>
    <strong>
       models/CompletedQuestModel.php:
    </strong>
    <br />
     - completeQuest($userId, $questId): Метод для отметки задания как выполненного для пользователя.
    <br />
     - isQuestCompleted($userId, $questId): метод для проверки выполнения задания пользователем ранее.
    <br />
     - getUserCompletedQuests($userId): Метод для получения истории выполненных заданий для пользователя.
  </li>
</ol>
    <br />
