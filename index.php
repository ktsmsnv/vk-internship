<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REST API VK тест</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            padding: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">REST API VK тест</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Создание пользователя</h2>
        </div>
        <div class="card-body">
            <form action="restapi/create_user.php" method="POST">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Создать пользователя</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Создание задания</h2>
        </div>
        <div class="card-body">
            <form action="restapi/create_quest.php" method="POST">
                <div class="form-group mb-3">
                    <label for="quest_name">Название задания:</label>
                    <input type="text" id="quest_name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="cost">Стоимость задания:</label>
                    <input type="number" id="cost" name="cost" class="form-control" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="custom" name="custom" value="1">
                    <label class="form-check-label" for="custom">Многоразовое задание</label>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Создать задание</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2>Выполнение задания</h2>
        </div>
        <div class="card-body">
            <form action="restapi/complete_quest.php" method="POST">
                <div class="form-group mb-3">
                    <label for="user_id">ID Пользователя:</label>
                    <input type="text" id="user_id" name="user_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="quest_id">ID Задания:</label>
                    <input type="text" id="quest_id" name="quest_id" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Засчитать задание выполненным</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>История пользователя</h2>
        </div>
        <div class="card-body">
            <form action="restapi/user_history.php" method="GET">
                <div class="form-group">
                    <label for="user_id_history">ID Пользователя:</label>
                    <input type="text" id="user_id_history" name="user_id" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Посмотреть историю пользователя</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
