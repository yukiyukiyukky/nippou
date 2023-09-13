<?php
require_once('config.php');
require_once('functions.php');

session_start();
try {
    // ログインチェック

    if (!isset($_SESSION['USER'])) {
        // ログインされていない場合はログイン画面へ強制遷移
        header('Location: ' . SITE_URL . 'login.php');

        exit;
    }



    // セッションからユーザ情報を取得

    $session_user = $_SESSION['USER']; //string　文字列型で取得　←echo gettype($user);を実行して文字列型で取得していることが確認できた。が、文字列$userになっていた
    // echo '<br />';
    // var_dump($user);
    // echo gettype($user);
    // echo 'CHECK POINT2<br />';
    // exit;
    // echo $user['id'];
    // exit;

    $pdo = connectDb();

    $err = array();

    $target_date = date('Y-m-d');


    // モーダルの自動表示判定　入出庫両方入力済みならモーダルを自動表示しない
    $modal_view_flg = TRUE;


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 日報登録処理

        // 入力内容をPOSTパラメーターから取得
        $target_date = $_POST['target_date'];
        $modal_start_mater = $_POST['modal_start_mater'];
        $modal_start_time = $_POST['modal_start_time'];
        $modal_end_mater = $_POST['modal_end_mater'];
        $modal_end_time = $_POST['modal_end_time'];
        $modal_hour_mater_start = $_POST['modal_hour_mater_start'];
        $modal_hour_mater_end = $_POST['modal_hour_mater_end'];
        $modal_break_time = $_POST['modal_break_time'];
        $modal_client = $_POST['modal_client'];
        $modal_project_name = $_POST['modal_project_name'];
        $modal_comment = $_POST['modal_comment'];


        // 出庫時間の必須／形式チェック
        if (!$modal_start_time) {
            $err['modal_start_time'] = '出庫時間を入力してください。';
        } elseif (!preg_match('/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $modal_start_time)) {
            $modal_start_time = '';
            $err['modal_start_time'] = '出庫時間を正しく入力してください。';
        }

        // 入庫時間の形式チェック
        if ($modal_end_time && !preg_match('/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $modal_end_time)) {
            $modal_end_time = '';
            $err['modal_end_time'] = '入庫時間を正しく入力してください。';
        }

        // 休憩時間の形式チェック
        if ($modal_break_time && !preg_match('/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $modal_break_time)) {
            $modal_break_time = '';
            $err['modal_break_time'] = '休憩時間を正しく入力してください。';
        }

        // 業務内容の最大サイズチェック
        if (mb_strlen($modal_comment, 'utf-8') > 2000) {
            $err['modal_comment'] = '業務内容が長すぎます。';
        }

        if (empty($err)) {
            // データベースに対象日のデータがあるかチェック
            $sql = "SELECT id FROM work WHERE user_id = :user_id AND date=:date LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', (int)$session_user['id'],  PDO::PARAM_INT);
            $stmt->bindValue(':date', $target_date, PDO::PARAM_STR);
            $stmt->execute();
            $work = $stmt->fetch();



            if ($work) {
                // 対象日のデータがあればUPDATEを実行
                $sql = "UPDATE work SET start_mater =:start_mater,
        start_time =:start_time,
        end_mater =:end_mater,
        end_time =:end_time,
        hour_mater_start =:hour_mater_start,
        hour_mater_end =:hour_mater_end,
        break_time =:break_time,
        client =:client,
        project_name=:project_name,
        comment=:comment WHERE id=:id";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', (int)$work['id'], PDO::PARAM_INT);
                $stmt->bindValue(':start_mater', $modal_start_mater, PDO::PARAM_STR);
                $stmt->bindValue(':start_time', $modal_start_time, PDO::PARAM_STR);
                $stmt->bindValue(':end_mater', $modal_end_mater, PDO::PARAM_STR);
                $stmt->bindValue(':end_time', $modal_end_time, PDO::PARAM_STR);
                $stmt->bindValue(':hour_mater_start', $modal_hour_mater_start, PDO::PARAM_STR);
                $stmt->bindValue(':hour_mater_end', $modal_hour_mater_end, PDO::PARAM_STR);
                $stmt->bindValue(':break_time', $modal_break_time, PDO::PARAM_STR);
                $stmt->bindValue(':client', $modal_client, PDO::PARAM_STR);
                $stmt->bindValue(':project_name', $modal_project_name, PDO::PARAM_STR);
                $stmt->bindValue(':comment', $modal_comment, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                //対象日のデータがなければINSERTを実行 

                $sql = "INSERT INTO work (user_id,date,start_mater, start_time,end_mater,end_time,
        hour_mater_start,hour_mater_end,break_time,client,project_name,comment)VALUES(:user_id,:date,:start_mater, :start_time,:end_mater,:end_time,
        :hour_mater_start,:hour_mater_end,:break_time,:client,:project_name,:comment)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':user_id', (int)$session_user['id'], PDO::PARAM_INT);
                $stmt->bindValue(':date', $target_date, PDO::PARAM_STR);
                $stmt->bindValue(':start_mater', $modal_start_mater, PDO::PARAM_STR);
                $stmt->bindValue(':start_time', $modal_start_time, PDO::PARAM_STR);
                $stmt->bindValue(':end_mater', $modal_end_mater, PDO::PARAM_STR);
                $stmt->bindValue(':end_time', $modal_end_time, PDO::PARAM_STR);
                $stmt->bindValue(':hour_mater_start', $modal_hour_mater_start, PDO::PARAM_STR);
                $stmt->bindValue(':hour_mater_end', $modal_hour_mater_end, PDO::PARAM_STR);
                $stmt->bindValue(':break_time', $modal_break_time, PDO::PARAM_STR);
                $stmt->bindValue(':client', $modal_client, PDO::PARAM_STR);
                $stmt->bindValue(':project_name', $modal_project_name, PDO::PARAM_STR);
                $stmt->bindValue(':comment', $modal_comment, PDO::PARAM_STR);
                $stmt->execute();
            }
            $modal_view_flg = FALSE;
        }
    } else {
        // modalのデフォルト表示
        // 当日のデータがあるかチェック
        $sql = "SELECT id,start_mater,start_time,end_mater,end_time,hour_mater_start,hour_mater_end,break_time,client,project_name,comment  FROM work WHERE user_id = :user_id AND date=:date LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', (int)$session_user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':date', date('Y-m-d'), PDO::PARAM_STR);
        $stmt->execute();
        $today_work = $stmt->fetch();



        if ($today_work) {
            $modal_start_mater = $today_work['start_mater'];
            $modal_start_time = $today_work['start_time'];
            $modal_end_mater = $today_work['end_mater'];
            $modal_end_time = $today_work['end_time'];
            $modal_hour_mater_start = $today_work['hour_mater_start'];
            $modal_hour_mater_end = $today_work['hour_mater_end'];
            $modal_break_time = $today_work['break_time'];
            $modal_client = $today_work['client'];
            $modal_project_name = $today_work['project_name'];
            $modal_comment = $today_work['comment'];


            if (format_time($modal_start_time) && format_time($modal_end_time)) {
                $modal_view_flg = FALSE;
            }
        } else {

            $modal_start_mater = '';
            $modal_start_time = '';
            $modal_end_mater = '';
            $modal_end_time = '';
            $modal_hour_mater_start = '';
            $modal_hour_mater_end = '';
            $modal_break_time = '01:00';
            $modal_client = '';
            $modal_project_name = '';
            $modal_comment = '';
        }
    }



    // ユーザーの業務日報のデータを取得

    // 月プルダウンリストが変更されたら変更された月を取得する
    if (isset($_GET['m'])) {

        // プルダウンから月の指定があった場合は月のデータを表示
        $yyyymm = $_GET['m'];
        $day_count = date('t', strtotime($yyyymm));

        if (count(explode('-', $yyyymm)) != 2) {
            throw new Exception('日付の指定が不正', 500);
        }

        // 今月～過去12ヵ月の範囲内かどうか
        $check_date = new DateTime($yyyymm . '-01');
        $start_date = new DateTime('first day of -11 month 00:00');
        $end_date = new DateTime('first day of this month 00:00');

        if ($check_date < $start_date || $end_date < $check_date) {
            throw new Exception('日付の範囲が不正', 500);
        }

        if ($check_date != $end_date) {
            // 表示している画面が当月じゃなければモーダルは自動表示しない
            $modal_view_flg = FALSE;
        }
    } else {
        // プルダウンから月の指定がなかった場合は当月のデータを表示
        $yyyymm = date('Y-m');
        $day_count = date('t');
    }





    $sql = "SELECT date,id,start_mater,start_time,end_mater,end_time,hour_mater_start,hour_mater_end,break_time,client,project_name,comment FROM work where user_id=:user_id AND DATE_FORMAT(date,'%Y-%m')=:date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id',  (int)$session_user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':date', $yyyymm, PDO::PARAM_STR);
    $stmt->execute();
    $work_list = $stmt->fetchAll(PDO::FETCH_UNIQUE);


    // echo '<pre>';
    // var_dump($work_list);
    // exit;

    // 取得した業務日報データをテーブルにリスト表示する




} catch (Exception $e) {
    header('Location: /error.php');
    exit;
}
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME | <?php echo SERVICE_NAME; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/nippou.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.min.js"></script>

    <!-- これがないとナビゲーションバーが展開しない -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Bundle with Popper.js -->
    <script src="js/jbvalidator.js"></script>

    <link rel="stylesheet" href="./css/all.min.css">

    <link rel="icon" href="./favicon.ico" id="favicon">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./android-chrome-192x192.png">
</head>


<body>
    <!-- トップ固定ナビゲーション -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo SITE_URL; ?>"><?php echo SERVICE_SHORT_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Navbar" aria-controls="Navbar" aria-expanded="false" aria-label="ナビゲーションの切替">
                <span class="navbar-toggler-icon"></span>
            </button>

            <?php $user = $_SESSION['USER'];
            //var_dump($user);
            //echo gettype($user);
            // echo 'CHECK POINT2<br />';
            //exit;
            ?>


            <div class="collapse navbar-collapse" id="Navbar">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong><?php echo $user['user_screen_name']; ?> さんがログイン中 </strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">新プロジェクト...</a></li>
                        <li><a class="dropdown-item" href="#">設定</a></li>
                        <li><a class="dropdown-item" href="#">プロフィール</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">サインアウト</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
    </header>
    <!-- トップ固定ナビゲーション -->




    <body class="text-center mt-5 bg-light">
        <div class="container">
            <img class="d-block mx-auto mb-4" src="./img/nippou.svg" alt="" width="100" height="100" loading="lazy">

            <body id="main">
                <form class="border rounded bg-white form-time-table" action="index.php">
                    <h3 class="h4 mt-5">月別リスト</h3>
                    <div class="card mx-5 my-5">
                        <div class="row mt-5">
                            <div class="col-3 my-3 mx-4">
                                <div class="input-group">
                                    <label for="exampleFormControlInput1" class="input-group-text">車両番号</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="車両番号">
                                </div>
                            </div>
                            <div class="col-3 my-3">
                                <div class="input-group">
                                    <label for="exampleFormControlInput1" class="input-group-text">運転手名</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" value="<?php echo $user['user_screen_name']; ?> ">
                                </div>
                            </div>
                            <div class="col-3 my-2 justify-content-end">

                            </div>

                        </div>
                        <div class="row mt-3 mx-2">
                            <div class="col-2">
                                <select class="form-control rounded-pill mb-3" name="m" onchange="submit(this.form)">
                                    <option value="<?= date('Y-m') ?>"><?= date('Y/m') ?></option>
                                    <?php for ($i = 1; $i < 12; $i++) : ?>
                                        <?php $target_yyyymm = strtotime("- {$i}months"); ?>
                                        <option value="<?= date('Y-m', $target_yyyymm) ?>" <?php if ($yyyymm == date('Y-m', $target_yyyymm)) echo 'selected' ?>><?= date('Y/m', $target_yyyymm) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <table class="table table-bordered table-hover mt-2">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="fix-col">日</th>
                                        <th class="fix-col">出庫メーター</th>
                                        <th class="fix-col">出庫</th>
                                        <th class="fix-col">入庫メーター</th>
                                        <th class="fix-col">入庫</th>
                                        <th class="fix-col">アワメーター始</th>
                                        <th class="fix-col">アワメーター終</th>
                                        <th class="fix-col">休憩</th>
                                        <th class="fix-col">客先</th>
                                        <th class="fix-col">日報現場</th>
                                        <th>作業内容</th>
                                        <th class="fix-col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 1; $i <= $day_count; $i++) : ?>
                                        <?php
                                        $start_mater = '';
                                        $start_time = '';
                                        $end_mater = '';
                                        $end_time = '';
                                        $hour_mater_start = '';
                                        $hour_mater_end = '';
                                        $break_time = '';
                                        $client = '';
                                        $project_name = '';
                                        $comment = '';
                                        $comment_long = '';

                                        if (isset($work_list[date('Y-m-d', strtotime($yyyymm . '-' . $i))])) {
                                            $work = $work_list[date('Y-m-d', strtotime($yyyymm . '-' . $i))];

                                            $start_mater = $work['start_mater'];

                                            if ($work['start_time']) {
                                                $start_time = date('H:i', strtotime($work['start_time']));
                                            }

                                            $end_mater = $work['end_mater'];

                                            if ($work['end_time']) {
                                                $end_time = date('H:i', strtotime($work['end_time']));
                                            }

                                            $hour_mater_start = $work['hour_mater_start'];
                                            $hour_mater_end = $work['hour_mater_end'];


                                            if ($work['break_time']) {
                                                $break_time = date('H:i', strtotime($work['break_time']));
                                            }
                                            if ($work['client']) {
                                                // 顧客名が20文字以上の場合は残りを...で表示
                                                $client = mb_strimwidth($work['client'], 0, 20, '...');
                                            }

                                            if ($work['project_name']) {
                                                // 現場名が40文字以上の場合は残りを...で表示
                                                $project_name = mb_strimwidth($work['project_name'], 0, 40, '...');
                                            }

                                            if ($work['comment']) {
                                                // 業務内容が40文字以上の場合は残りを...で表示
                                                $comment = mb_strimwidth($work['comment'], 0, 40, '...');
                                            }
                                        }

                                        ?>
                                        <tr>
                                            <th scope="row"><?= time_format_dw($yyyymm . '-' . $i) ?></th>
                                            <td><?= $start_mater ?></td>
                                            <td><?= $start_time ?></td>
                                            <td><?= $end_mater ?></td>
                                            <td><?= $end_time ?></td>
                                            <td><?= $hour_mater_start ?></td>
                                            <td><?= $hour_mater_end ?></td>
                                            <td><?= $break_time ?></td>
                                            <td><?= $client ?></td>
                                            <td><?= $project_name ?></td>
                                            <td><?= $comment ?></td>
                                            <td class="d-none"><?= $comment_long ?></td>
                                            <td><button type="button" class="btn btn-default h-auto py-0" data-bs-toggle="modal" data-bs-target="#inputModal" data-bs-month="<?= date('n', strtotime($yyyymm . '-' . $i)) ?>" data-bs-day="<?= $yyyymm . '-' . sprintf('%02d', $i) ?>"><i class="fas fa-pencil-alt"></i></button></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </form>
                <div class="row  d-flex justify-content-center mt-2">
                    <!-- モーダルの設定 -->
                    <form method="POST" class="needs-validation row g-3" novalidate>

                        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p></p>
                                        <h1 class="modal-title fs-5" id="inputModalLabel">日報登録</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container text-center">
                                            <div class="alert alert-primary" role="alert">
                                                <span id="modal_month"><?= date('n', strtotime($target_date)) ?></span>/<span id="modal_day"><?= time_format_dw($target_date) ?></span>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3">
                                                    <select class="form-select" id="modal_project_name" name="modal_project_name" placeholder="現場名" value="<?= $modal_project_name ?>">
                                                        <option>○○ビル建設工事</option>
                                                        <option>○○風力建設工事</option>
                                                        <option>その3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3">
                                                    <select class="form-select" id="modal_client" name="modal_client" placeholder="顧客名" value="<?= $modal_client ?>">
                                                        <option>モグラ建設(株)</option>
                                                        <option>ぶんぶんファーム(株)</option>
                                                        <option>その3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="出庫メーター" id="modal_start_mater" name="modal_start_mater" value="<?= $modal_start_mater ?>">
                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control<?php if (isset($err['modal_start_time'])) echo ' is-invalid'; ?>" placeholder="出庫" id="modal_start_time" name="modal_start_time" value="<?= format_time($modal_start_time) ?>" required>
                                                        <button type="button" class="input-group-text" id="start_btn">打刻</button>
                                                        <div class="invalid-feedback"><?= $err['modal_start_time'] ?></div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="入庫メーター" id="modal_end_mater" name="modal_end_mater" value="<?= $modal_end_mater ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control<?php if (isset($err['modal_end_time'])) echo ' is-invalid'; ?>" placeholder="入庫" id="modal_end_time" name="modal_end_time" value="<?= format_time($modal_end_time) ?>">
                                                        <button type="button" class="input-group-text" id="end_btn">打刻</button>
                                                        <div class="invalid-feedback"><?= $err['modal_end_time'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="アワメーター始" id="modal_hour_mater_start" name="modal_hour_mater_start" value="<?= $modal_hour_mater_start ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="アワメーター終" id="modal_hour_mater_end" name="modal_hour_mater_end" value="<?= $modal_hour_mater_end ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-5">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="end_btn">休憩</span>
                                                        <input type="text" class="form-control<?php if (isset($err['modal_break_time'])) echo ' is-invalid'; ?>" placeholder="休憩" id="modal_break_time" name="modal_break_time" value="<?= format_time($modal_break_time) ?>">
                                                        <div class="invalid-feedback"><?= $err['modal_break_time'] ?></div>
                                                    </div>

                                                </div>
                                                <div class="mb-3 pt-3">
                                                    <textarea class="form-control" rows="5" placeholder="業務内容" id="modal_comment" name="modal_comment" value="<?= $modal_comment ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary text-white rounded-pill px-5">登録</button>
                                    </div><!-- /.modal-footer -->
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <input type="hidden" id="target_date" name="target_date" value="<?= h($target_date) ?>">
                    </form>
                </div>





            </body>
        </div>

        <!-- 画面表示時にモーダルを自動表示させる -->
        <script>
            <?php if ($modal_view_flg) : ?>
                var inputModal = new bootstrap.Modal(document.getElementById('inputModal'));
                inputModal.toggle();
            <?php endif; ?>

            // モーダルの打刻ボタンを押したときの処理
            // 現在時刻を取得して表示　一桁の時は0で埋めて2桁表示にする
            // 出庫時間の打刻
            $('#start_btn').click(function() {
                const now = new Date();
                const hour = now.getHours().toString().padStart(2, '0');
                const minute = now.getMinutes().toString().padStart(2, '0');
                $('#modal_start_time').val(hour + ':' + minute);
                // console.log(hour + ':' + minute);
            })

            // 入庫時間の打刻
            $('#end_btn').click(function() {
                const now = new Date();
                const hour = now.getHours().toString().padStart(2, '0');
                const minute = now.getMinutes().toString().padStart(2, '0');
                $('#modal_end_time').val(hour + ':' + minute);
                // console.log(hour + ':' + minute);
            })


            $('#inputModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var target_month = button.data('bs-month')
                var target_day = button.data('bs-day');
                // console.log(target_day);
                // $(this).off('show.bs.modal');

                // モーダル内の要素を取得
                var modal_month = $('#modal_month');
                var modal_day = $('#modal_day');

                // 要素の内容を書き換え
                modal_month.text(target_month);
                modal_day.text(target_day);






                // 編集ボタンが押された対象日の表データを取得
                var day = button.closest('tr').children('th')[0].innerText;
                var start_mater = button.closest('tr').children('td')[0].innerText;
                var start_time = button.closest('tr').children('td')[1].innerText;
                var end_mater = button.closest('tr').children('td')[2].innerText;
                var end_time = button.closest('tr').children('td')[3].innerText;
                var hour_mater_start = button.closest('tr').children('td')[4].innerText;
                var hour_mater_end = button.closest('tr').children('td')[5].innerText;
                var break_time = button.closest('tr').children('td')[6].innerText;
                var client = button.closest('tr').children('td')[7].innerText;
                var project_name = button.closest('tr').children('td')[8].innerText;
                var comment = button.closest('tr').children('td')[9].innerText;


                // 取得したデータをモーダルの各欄に設定
                $('#modal_day').text(day)
                $('#modal_start_mater').val(start_mater)
                $('#modal_start_time').val(start_time)
                $('#modal_end_mater').val(end_mater)
                $('#modal_end_time').val(end_time)
                $('#modal_hour_mater_start ').val(hour_mater_start)
                $('#modal_hour_mater_end').val(hour_mater_end)
                $('#modal_break_time').val(break_time)
                $('#modal_client').val(client)
                $('#modal_project_name').val(project_name)
                $('#modal_comment').val(comment)
                $('#target_date').val(target_day)

                /* エラー表示をクリア */
                $('#modal_start_mater').removeClass(' is-invalid')
                $('#modal_start_time').removeClass(' is-invalid')
                $('#modal_end_mater').removeClass(' is-invalid')
                $('#modal_end_time').removeClass(' is-invalid')
                $('#modal_hour_mater_start ').removeClass(' is-invalid')
                $('#modal_hour_mater_end').removeClass(' is-invalid')
                $('#modal_break_time').removeClass(' is-invalid')
                $('#modal_client').removeClass(' is-invalid')
                $('#modal_project_name').removeClass(' is-invalid')
                $('#modal_comment').removeClass(' is-invalid')
                $('#target_date').removeClass(' is-invalid')
            })
        </script>

    </body>







    <script>
        $(function() {

            let validator = $('form.needs-validation').jbvalidator({
                errorMessage: true,
                successClass: true,
                language: 'dist/lang/ja.json'
            });

            //new custom validate methode
            validator.validator.custom = function(el, event) {

                if ($(el).is('[name=password]') && $(el).val().length < 5) {
                    return 'Your password is too weak.';
                }

                return '';
            }

            let validatorServerSide = $('form.validatorServerSide').jbvalidator({
                errorMessage: true,
                successClass: true,
            });

            //serverside
            $(document).on('submit', '.validatorServerSide', function() {

                $.ajax({
                    method: "get",
                    url: "test.json",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data.status === 'error') {
                            validatorServerSide.errorTrigger($('[name=username]'), data.message);
                        }
                    }
                })

                return false;
            });
        })
    </script>
    <hr>
    <footer class="footer  mx-5">
        <p><?php echo COPYRIGHT; ?></p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">プライバシー</a></li>
            <li class="list-inline-item"><a href="#">条項</a></li>
            <li class="list-inline-item"><a href="#">サポート</a></li>
        </ul>
    </footer>
    </div>

</body>

</html>