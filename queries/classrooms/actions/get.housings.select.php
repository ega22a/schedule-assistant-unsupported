<?php
    // Совершаем соединение к БД
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config/mysql/connect.php';

    $query = "SELECT * FROM `housings`";
    $query = $MySQL -> query($query);
    echo '
        <div class="mdl-selectfield">
            <select>
                <option disabled selected>Выберите корпус</option>
    ';
    while ($row = $query -> fetch_assoc()) {
        echo '<option value=\'' . $row['id'] . '\'>Корпус ' . $row['numberOfHousing'] . ' (' . $row['dislocation'] . ')</option>';
    }
    echo '
            </select>
        </div>
    ';
?>