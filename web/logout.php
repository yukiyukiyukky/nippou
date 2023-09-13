<?php
require_once('config.php');
require_once('functions.php');

session_start();

$_SESSION = array();

session_destroy();

//header('Location: /login.php');


?>


<!doctype html>
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
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
                <div class="dropdown">
                    <strong> お疲れ様でした！ </strong>

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

<br />




<body class="text-center bg-light mt-5">
    <form class="boder rounded bg-white form-login" action="signup_complete.php">
        <h1 class="h4 alert alert-success">ログアウトが完了しました。</h1>
        <a href="login.php">トップページへ</a>
    </form>
    <script src="js/bootstrap.bundle.min.js"></script>

    <hr>
    <footer class="footer  mx-5">
        <!--<p><?php echo COPYRIGHT; ?></p>-->
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">プライバシー</a></li>
            <li class="list-inline-item"><a href="#">条項</a></li>
            <li class="list-inline-item"><a href="#">サポート</a></li>
        </ul>
    </footer>
    </div>

</body>

</html>