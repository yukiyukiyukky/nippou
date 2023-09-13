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

            if ($user) {

                $err['user_email'] = 'このメールアドレスは既に登録されています。';
            }
        }
    // もし$err配列に何もエラーメッセージが保存されていなかったら

    if (empty($err)) {

        // 処理3

        // データベース（userテーブル）に新規登録する。

        $sql = "insert into user

             (user_screen_name, user_no, user_birthday, joining_company_day, user_email, user_password,  delivery_hour, created_at, updated_at)

             values

             (:user_screen_name, :user_no,  :user_birthday, :joining_company_day, :user_email, :user_password, 99, now(), now())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_screen_name', $user_screen_name);
        $stmt->bindValue(':user_no', $user_no);
        $stmt->bindValue(':user_birthday', $user_birthday);
        $stmt->bindValue(':joining_company_day', $joining_company_day);
        $stmt->bindValue(':user_email', $user_email);
        $stmt->bindValue(':user_password', $user_password);


        $flag = $stmt->execute();


        // 自動ログイン

        $sql = "select * from user where user_no = :user_no and user_birthday=:user_birthday and BINARY user_password = :user_password limit 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":user_no" => $user_no, "user_birthday" => $user_birthday, ":user_password" => $user_password));
        $user = $stmt->fetch();
        $_SESSION['USER'] = $user;
        //unset($pdo);

        // signup_complete.phpに画面遷移する。

        header('Location: ' . SITE_URL . 'signup_complete.php');


        // unset($pdo);


        // 処理4

        // signup_complete.phpに画面遷移する。
        header('Location: ' . SITE_URL . 'signup_complete.php');

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
                                <h3>ユーザー登録</h3>

                                <form class="needs-validation row g-3" novalidate>
                                    <div class="col-12 bg-light">
                                        <div class="p-2">
                                            <label class=float-start>社員コード</label>
                                            <input type="text" name="user_no" class="form-control rounded-pill" pattern="[0-9]+" title="半角数字で入力してください" data-v-min-length="6" data-v-max-length="6" 　title="Only number." value="<?php echo $user_no; ?>" required>
                                            <span class="glyphicon form-control-feedback glyphicon-remove text-danger" aria-hidden="true"><?php echo $err['user_no']; ?></span>

                                        </div>


                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start>社員名</label>
                                                <input type="text" name="user_screen_name" class="form-control rounded-pill" pattern="[^\x20-\x7E]*" title="漢字またはひらがなで入力してください" data-v-min-length="2" value="<?php echo $user_screen_name; ?>" required>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start>生年月日</label>
                                                <input type="date" name="user_birthday" class="form-control rounded-pill" min="1000-10-20" value="<?php echo $user_birthday; ?>" required>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start>入社年月日</label>
                                                <input type="date" name="joining_company_day" class="form-control rounded-pill" min="1000-10-20" value="<?php echo $joining_company_day; ?>" required>
                                            </div>

                                        </div>


                                        <div class="col-12 bg-light">


                                            <div class="p-2">
                                                <label class=float-start>Eメール<span class="text-muted">(任意)</span></label>
                                                <input type="email" class="form-control rounded-pill" name="user_email" placeholder="name@example.com" value="<?php echo $user_email; ?>" title="このアドレスは既に登録されています。">
                                                <span class="glyphicon form-control-feedback glyphicon-remove text-danger" aria-hidden="true"><?php echo $err['user_email']; ?></span>

                                            </div>




                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start for="password">パスワード</label>
                                                <input type="password" name="user_password" class="form-control rounded-pill" id="password" title="password" required>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="p-2">
                                                <label class=float-start for="password">パスワード確認</label>
                                                <input name="repassword" type="password" class="form-control rounded-pill" data-v-equal="#password" required>
                                            </div>

                                        </div>

                                        <div class="col-12 bg-light">
                                            <div class="col-12 p-1" data-checkbox-group data-v-min-select="1" data-v-required>
                                                <hr>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        個人データを登録することに同意します。
                                                    </label>
                                                </div>
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
                                        <input type="submit" class="btn btn-primary rounded-pill" value="アカウントを作成">
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