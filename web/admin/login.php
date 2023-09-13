<?php

require_once('../config.php');
require_once('../functions.php');

session_start();

if (isset($_SESSION['USER']) && $_SESSION['USER']['auth_type'] == 1) {
    //ログイン済みの場合はHOME画面へ遷移

    // HOME画面に遷移する。

    header('Location:' . SITE_URL . 'admin/user_list.php');

    exit;
}



if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // 初めて画面にアクセスした時の処理

} else {

    // フォームからサブミットされた時の処理



    // 入力されたメールアドレス、パスワードを受け取り、変数に入れる。

    $user_no = $_POST['user_no'];
    $user_birthday = $_POST['user_birthday'];
    $user_password = $_POST['user_password'];
    // 処理2

    // データベースに接続する（PDOを使う）

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "skill_record";
    $param = "mysql:dbname=" . $db . ";host=" . $host;



    $pdo = new PDO($param, $user, $pass);
    $pdo->query('SET NAMES utf8;');



    // 入力チェックを行う。

    $err = array();

    if ($user_no == '') {

        // [社員コード]未入力チェック

        $err['user_no'] = '社員コードを入力して下さい。';
    } else {

        // [社員コード]存在チェック

        $sql = "select * from user where user_no = :user_no limit 1";

        $stmt = $pdo->prepare($sql);

        $stmt->execute(array(":user_no" => $user_no));

        $user = $stmt->fetch();

        if (!$user) {

            $err['user_no'] = 'この社員コードが登録されていません。';
        }
    }



    // [生年月日]未入力チェック

    if ($user_birthday == '') {

        $err['user_birthday'] = '生年月日を入力して下さい。';
    } else {

        // [生年月日]存在チェック
        $sql = "select * from user where user_birthday = :user_birthday limit 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":user_birthday" => $user_birthday));
        $user = $stmt->fetch();
        if (!$user) {
            $err['user_birthday'] = 'この生年月日は登録がありません。';
        }
    }


    // [パスワード]未入力チェック

    if ($user_password == '') {
        $err['user_password'] = 'パスワードを入力して下さい。';
    }



    // もし$err配列に何もエラーメッセージが保存されていなかったら

    if (empty($err)) {

        $param = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
        $pdo = new PDO($param, DB_USER, DB_PASSWORD);
        $pdo->query('SET NAMES utf8;');

        $sql = "SELECT user_no,user_birthday,user_screen_name,auth_type FROM user WHERE user_no = :user_no AND user_birthday=:user_birthday AND user_password =:user_password AND auth_type LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_no', $user_no, PDO::PARAM_STR);
        $stmt->bindValue(':user_birthday', $user_birthday, PDO::PARAM_STR);
        $stmt->bindValue(':user_password', $user_password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();


        //var_dump($user);
        //exit;

        if ($user) {
            //ログイン処理(セッションに保存）
            $_SESSION['USER'] = $user;

            // HOME画面に遷移する。

            header('Location:' . SITE_URL . '/admin/user_list.php');

            exit;
        } else {
            $err['user_password'] = '認証に失敗しました';
        }

        unset($pdo);
    }
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME | <?php echo SERVICE_NAME; ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/nippou.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="icon" href="../favicon.ico" id="favicon">
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../android-chrome-192x192.png">

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

                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">新プロジェクト...</a></li>
                        <li><a class="dropdown-item" href="#">設定</a></li>
                        <li><a class="dropdown-item" href="#">プロフィール</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../logout.php">サインアウト</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
    </header>
    <!-- トップ固定ナビゲーション -->

    <body class="bg-info">
        <div class="container">

            <main>
                <form method="post" class="needs-validation" novalidate>
                    <div class="py-5 text-center">
                        <img class="d-block mx-auto mb-4" src="../img/nippou.svg" alt="" width="100" height="100" loading="lazy">
                        <div class="card mx-auto" style="width:60%;">
                            <div class="card-body my-4">
                                <h2>Login</h2>

                                <form class="needs-validation row g-3" novalidate>
                                    <div class="col-12 bg-light">
                                        <div class="p-2">
                                            <label class=float-start for="password">社員コード</label>
                                            <input type="text" name="user_no" class="form-control rounded-pill" pattern="[0-9]+" title="半角数字で入力してください" data-v-min-length="6" data-v-max-length="6" 　title="Only number." value="<?php echo $user_no; ?>" required>
                                            <span class="glyphicon form-control-feedback glyphicon-remove text-danger" aria-hidden="true"><?php echo $err['user_no']; ?></span>

                                        </div>
                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start>生年月日</label>
                                                <input type="date" name="user_birthday" class="form-control rounded-pill" min="1000-10-20" value="<?php echo $user_birthday; ?>" required>
                                                <span class="glyphicon form-control-feedback glyphicon-remove text-danger" aria-hidden="true"><?php echo $err['user_birthday']; ?></span>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start for="password">パスワード</label>
                                                <input type="password" name="user_password" class="form-control rounded-pill" id="user_password" title="user_password" required>
                                                <span class="glyphicon form-control-feedback glyphicon-remove text-danger" aria-hidden="true"><?php echo $err['user_password']; ?></span>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start for="password">パスワード確認</label>
                                                <input name="reuser_password" type="password" class="form-control rounded-pill" data-v-equal="#user_password" required>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="col-12 p-1" data-checkbox-group data-v-min-select="1" data-v-required>
                                                <hr>

                                            </div>
                                        </div>


                                        <div class="col-12 p-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                                <label class="form-check-label" for="defaultCheck2">
                                                    次回から自動ログイン
                                                </label>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="col-12 mt-3">
                                        <input type="submit" class="btn btn-secondary rounded-pill" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1.5rem; --bs-btn-font-size: 1.00rem;" value="ログイン"></a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>



                    <script src="../js/jquery-3.5.1.min.js" crossorigin="anonymous"></script>


                    <script src="../js/bootstrap.bundle.min.js"></script>
                    <script src="../js/jbvalidator.js"></script>
                    <script>
                        $(function() {

                            let validator = $('form.needs-validation').jbvalidator({
                                errorMessage: true,
                                successClass: true,
                                language: '../dist/lang/ja.json'
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


                        })
                    </script>



        </div>
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