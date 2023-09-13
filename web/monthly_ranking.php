<?php
require_once('config.php');
require_once('functions.php');



// データベースに接続
$pdo = connectDb();

// 月ごとのランキングデータを取得
$monthlyRanking = getMonthlyRanking($pdo);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>月ごとのランキング</title>
</head>

<body>
    <h1>月ごとのランキング</h1>
    <table>
        <tr>
            <th>月</th>
            <th>ユーザーID</th>
            <th>ユーザー名</th>
            <th>月累計勤務時間</th>
            <th>月間ランキング</th>
        </tr>
        <?php foreach ($monthlyRanking as $row) : ?>
            <tr>
                <td><?= h($row['month']) ?></td>
                <td><?= h($row['user_id']) ?></td>
                <td><?= h($row['user_screen_name']) ?></td>
                <td><?= h($row['worked_hours']) ?> 時間</td>
                <td><?= h($row['monthly_rank']) ?> 位</td>
            </tr>
        <?php endforeach; ?>
    </table>


</body>

</html>