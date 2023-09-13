<?php
// データベースに接続する
function connectDb()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "nippou";
    $param = "mysql:dbname=" . $db . ";host=" . $host;
    $pdo = new PDO($param, $user, $pass);
    $pdo->query('SET NAMES utf8;');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}



// 社員コードの存在チェック

function checkUser_no($user_no, $pdo)
{

    $sql = "select * from user where user_no = :user_no limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_no" => $user_no));
    $user = $stmt->fetch();

    return $user ? true : false;
}




// 社員コードと生年月日、パスワードからuserを検索する

function getUser($user_no, $user_birthday, $user_password, $pdo)
{
    $sql = "select * from user where user_no = :user_no and user_birthday = :user_birthday and BINARY user_password = :user_password limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_no" => $user_no, ":user_birthday" => $user_birthday, ":user_password" => $user_password));
    $user = $stmt->fetch();
    return $user ? $user : false;
}


// 配列からプルダウンメニューを生成する

function arrayToSelect($inputName, $srcArray, $selectedIndex = "")
{

    $temphtml = '<select class="form-control" name="' . $inputName . '">' . "\n";

    foreach ($srcArray as $key => $val) {
        if ($selectedIndex == $key) {
            $selectedText = ' selected="selected"';
        } else {
            $selectedText = '';
        }
        $temphtml .= '<option value="' . $key . '"' . $selectedText . '>' . $val . '</option>' . "\n";
    }

    $temphtml .= '</select>' . "\n";
    return $temphtml;
}



//HTMLエスケープ処理
function h($original_str)
{
    if ($original_str) {
        return htmlspecialchars($original_str, ENT_QUOTES, "UTF-8");
    } else {
        return NULL;
    }
}


// トークンを発行する処理
function setToken()
{
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['sstoken'] = $token;
}



// トークンをチェックする処理
function checkToken()
{
    if (empty($_SESSION['sstoken']) || ($_SESSION['sstoken'] != $_POST['token'])) {
        echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです。</body></html>';
        exit;
    }
}


// ユーザIDからuserを検索する

function getUserbyUserId($user_id, $pdo)
{
    $sql = "select * from user where id = :user_id limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":user_id" => $user_id));
    $user = $stmt->fetch();
    return $user ? $user : false;
}





// //ファイルデータを保存
// $filename ファイル名
// $save_path 保存先のパス
// $caption 投稿の説明
//  $user_id 画像のユーザー名, 
//  $licence　画像の資格, 
//  $publication_number　画像の発行番号;
// $result 
//file_tableに登録したいデータの設定を次行とfile_upload.phpの中で行う。
function  fileSave($filename, $save_path, $caption, $user_id, $licence, $publication_number, $front_back)
{
    $result = False;

    $sql = "INSERT INTO file_table (filename, save_path, caption, user_id, licence_id, publication_number, front_back) VALUE (?,?,?,?,?,?,?)";

    try {
        $stmt = connectDb()->prepare($sql);
        $stmt->bindValue(1, $filename);
        $stmt->bindValue(2, $save_path);
        $stmt->bindValue(3, $caption);
        $stmt->bindValue(4, $user_id,);
        $stmt->bindValue(5, $licence);
        $stmt->bindValue(6, $publication_number);
        $stmt->bindValue(7, $front_back);

        $result = $stmt->execute();

        return $result;
    } catch (\Exception $e) {
        echo $e->getMessage();
        return $result;
    }
}


// //ファイルデータを取得
// array $fileData
function getAllFile()
{
    $sql = "SELECT*FROM file_table";

    $fileData = connectDb()->query($sql);

    return  $fileData;
}




// 日本語の曜日表示 日付を日（曜日）の形式に変換する
function time_format_dw($date)
{
    $format_date = NULL;
    $week = array('日', '月', '火', '水', '木', '金', '土');

    if ($date) {
        $format_date = date('j(' . $week[date('w', strtotime($date))] . ')', strtotime($date));
    }

    return $format_date;
}


// 時間のデータ形式を調整する
function format_time($time_str)
{
    if (!$time_str || $time_str == '00:00:00') {
        return NULL;
    } else {
        return date('H:i', strtotime($time_str));
    }
}






// 月ごとのランキングを計算し、データを取得する関数
function getMonthlyRanking($pdo)
{
    try {
        // 月ごとのランキングを取得するSQLクエリを実行
        $sql = "
        WITH MonthlyWorkedHours AS (
            SELECT
                w.user_id,
                DATE_FORMAT(w.date, '%Y-%m') AS month,
                SUM(TIME_TO_SEC(TIMEDIFF(w.end_time, w.start_time)) / 3600) AS worked_hours,
                u.user_screen_name
            FROM
                work w
            INNER JOIN
                user u ON w.user_id = u.id
            GROUP BY
                w.user_id,
                DATE_FORMAT(w.date, '%Y-%m')
        )
        SELECT
            mw.user_id,
            mw.month,
            mw.user_screen_name,
            mw.worked_hours,
            RANK() OVER (PARTITION BY mw.month ORDER BY mw.worked_hours DESC) AS monthly_rank
        FROM
            MonthlyWorkedHours mw
        ORDER BY
            mw.month,
            monthly_rank;
        ";
        $stmt = $pdo->query($sql);

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }

        return $results;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
