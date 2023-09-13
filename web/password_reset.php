<?php

require_once('config.php');
require_once('functions.php');

if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    // 初めて画面にアクセスした時の処理

} else {

    // フォームからサブミットされた時の処理



    // 処理1

    // 入力されたニックネーム、メールアドレス、パスワードを受け取り、変数に入れる。

    $user_screen_name = $_POST['user_screen_name'];
    $user_no = $_POST['user_no'];
    $user_birthday = $_POST['user_birthday'];
    $joining_company_day = $_POST['joining_company_day'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    // 処理2

    // データベースに接続する（PDOを使う）

    /*$host = "localhost";
    $user = "root";
    $pass = "";
    $db = "skill_record";
    $param = "mysql:dbname=" . $db . ";host=" . $host;
    $pdo = new PDO($param, $user, $pass);
    $pdo->query('SET NAMES utf8;');*/


    $pdo = connectDb();
    // 入力チェックを行う。
    $err = array();

    if ($user_no != '') {

        // [社員コード]存在チェック

        /*$host = "localhost";
        $user = "root";
        $pass = "";
        $db = "skill_record";
        $param = "mysql:dbname=" . $db . ";host=" . $host;
        $pdo = new PDO($param, $user, $pass);
        $pdo->query('SET NAMES utf8;');*/

        $sql = "select * from user where user_no = :user_no limit 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":user_no" => $user_no));
        $user = $stmt->fetch();
        if ($user) {
            $err['user_no'] = 'この社員番号は既に登録されています。';
        }
    }

    if ($user_email != '')

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {

            // [メールアドレス]形式チェック
            $err['user_email'] = 'メールアドレスが不正です。';
        } else {

            // [メールアドレス]存在チェック
            $sql = "select * from user where user_email = :user_email limit 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(":user_email" => $user_email));
            $user = $stmt->fetch();

            if (!$user) {

                $err['user_email'] = 'このメールアドレスは登録がありません。';
            }
        }
    // もし$err配列に何もエラーメッセージが保存されていなかったら

    if (empty($err)) {

        // signup_complete.phpに画面遷移する。

        header('Location: ' . SITE_URL . 'password_reset_complete.php');


        exit;
    }
    // unset($pdo);
}


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME | nippou</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/nippou.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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

    <body class="bg-light">
        <div class="container">

            <main>
                <form method="post" class="needs-validation" novalidate>
                    <div class="py-5 text-center">
                        <img class="d-block mx-auto mb-4" src="./img/nippou.svg" alt="" width="100" height="100" loading="lazy">
                        <div class="card mx-auto" style="width:60%;">
                            <div class="card-body my-4">
                                <h3>パスワードリセット</h3>

                                <form class="needs-validation row g-3" novalidate>
                                    <div class="col-12 bg-light">
                                        <div class="p-2">
                                            <label class=float-start>Eメール</label>
                                            <input type="email" class="form-control rounded-pill" name="user_email" placeholder="name@example.com" value="<?php echo $user_email; ?>" title="このアドレスは既に登録されています。" required>
                                            <span class="glyphicon form-control-feedback glyphicon-remove text-danger" aria-hidden="true"><?php echo $err['user_email']; ?></span>
                                            <div class="invalid-feedback">
                                                有効なメールアドレスを入力してください
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 bg-light">
                                        <div class="col-12 p-1" data-checkbox-group data-v-min-select="1" data-v-required>
                                            <hr>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    登録済みのメールアドレスに仮パスワードを送信します。<br />
                                                    仮パスワードでログイン後、パスワードを任意のパスワードに変更してください。<br />
                                                    メールアドレスの登録が無い場合は管理者にお知らせください。
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-12 my-5">
                                <input type="submit" class="btn btn-danger rounded-pill" value="パスワードリセット">
                            </div>
                </form>
        </div>
        </div>

        </div>



        <script src="js/jquery-3.5.1.min.js" crossorigin="anonymous"></script>


        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jbvalidator.js"></script>
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