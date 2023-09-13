<?php
require_once('../config.php');
require_once('../functions.php');
session_start();

// ログインチェック

if (!isset($_SESSION['USER']) || $_SESSION['USER']['auth_type'] != 1) {

    header('Location:login.php');

    exit;
}

$pdo = connectDb();

$sql = "SELECT*FROM user";
$stmt = $pdo->query($sql);
$user_list = $stmt->fetchAll();

// セッションからユーザ情報を取得

$user = $_SESSION['USER']; //string　文字列型で取得　←echo gettype($user);を実行して文字列型で取得していることが確認できた。が、文字列$userになっていた
//var_dump($user);
//echo gettype($user);
//echo 'CHECK POINT2<br />';
//exit;


?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME | <?php echo SERVICE_NAME; ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/nippou.css" rel="stylesheet">
    <link rel="icon" href="../favicon.ico" id="favicon">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/apple-touch-icon-180x180.png">
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
                        <li><a class="dropdown-item" href="../logout.php">サインアウト</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
    </header>
    <!-- トップ固定ナビゲーション -->




    <body class="text-center mt-4  bg-info">
        <div class="container">
            <img class="d-block mx-auto mb-4" src="../img/nippou.svg" alt="" width="100" height="100" loading="lazy">

            <body id="main bg-info">
                <form class="needs-validation row g-3" novalidate>
                    <form class="border rounded bg-light form-user-list py-5 px-3" action="signup_complete.php">
                        <div class="card">
                            <h3 class="h4 my-3 mt-5">社員一覧</h3>
                            <div class="row mt-3 mx-5">
                                <table class="table table-bordered table-hover mt-5">
                                    <thead>
                                        <tr class="bg-light">
                                            <th scope="col">所属</th>
                                            <th scope="col">社員番号</th>
                                            <th scope="col">社員名</th>
                                            <th scope="col">権限</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user_list as $user) : ?>
                                            <tr>
                                                <td scope="row"><?= $user['business_office_id']; ?></td>
                                                <td><?= $user['user_no']; ?></td>
                                                <td><a href="user_result.php?id=<?= $user['id'] ?>"><?= $user['user_screen_name']; ?></a></td>
                                                <td><?php if ($user['auth_type'] == 1) echo '管理者' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </form>
                </form>
            </body>

        </div>
    </body>
</body>








<script src="../js/jquery-3.5.1.min.js"></script>

<!-- これがないとナビゲーションバーが展開しない -->
<script src="../js/bootstrap.bundle.min.js"></script>
<!-- JavaScript Bundle with Popper.js -->
<script src="../js/jbvalidator.js"></script>
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