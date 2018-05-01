<?php
    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    $query = "SELECT * FROM `housings`";
    $query = $MySQL -> query($query);
    echo '<select class="ro-select" name=\'housing\' placeholder="Выберите корпус">';
    while ($row = $query -> fetch_assoc()) {
        echo '<option value=\'' . $row['id'] . '\'>Корпус ' . $row['numberOfHousing'] . ' (' . $row['dislocation'] . ')</option>';
    }
    echo '
        </select>
    ';
?>