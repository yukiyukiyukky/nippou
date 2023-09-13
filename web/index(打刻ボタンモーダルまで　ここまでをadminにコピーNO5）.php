<?php
require_once('config.php');
session_start();

// ログインチェック

if (!isset($_SESSION['USER'])) {

    header('Location: ' . SITE_URL . 'login.php');

    exit;
}



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
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/bootstrap.min.js"></script>
    <link href="./css/nippou.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
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




    <body class="text-center mt-5">
        <div class="container">

            <body id="main">
                <form class="needs-validation row g-3" novalidate>
                    <form class="border rounded bg-light form-time-table py-5 px-3" action="signup_complete.php">
                        <h3 class="h4 my-3"><?php echo $user['user_screen_name']; ?> さんの作業日報</h3>
                        <div class="card">
                            <div class="row mt-5">
                                <div class="col-3 my-2">
                                    <div class="input-group">
                                        <label for="exampleFormControlInput1" class="input-group-text">車両番号</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="車両番号">
                                    </div>
                                </div>
                                <div class="col-3 my-2">
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
                                    <select class="form-select rounded-pill" id="exampleFormSelect1">
                                        <option value="1">2023/11</option>
                                    </select>
                                </div>

                                <table class="table table-bordered table-hover mt-2">
                                    <thead>
                                        <tr class="bg-light">
                                            <th scope="col">日</th>
                                            <th scope="col">出庫メーター</th>
                                            <th scope="col">出庫</th>
                                            <th scope="col">入庫メーター</th>
                                            <th scope="col">入庫</th>
                                            <th scope="col">アワメーター始</th>
                                            <th scope="col">アワメーター終</th>
                                            <th scope="col">休憩</th>
                                            <th scope="col">客先</th>
                                            <th scope="col">日報現場</th>
                                            <th scope="col">作業内容</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1(水)</th>
                                            <td>30000</td>
                                            <td>09：00</td>
                                            <td>60000</td>
                                            <td>18：00</td>
                                            <td>111111</td>
                                            <td>222222</td>
                                            <td>1:00</td>
                                            <td>㈱クレーン協会</td>
                                            <td>北海道風車1号機サイト</td>
                                            <td>テストテストテストテストテスト</td>
                                            <td><img src="../web/img/pencil-solid.svg" alt="" width="20" height="20"></td>

                                        </tr>
                                </table>
                            </div>




                        </div>
                        <div class="row  d-flex justify-content-center mt-2">
                            <!-- 切り替えボタンの設定 -->
                            <button type="button" class="btn btn-primary col-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                ココを押すと表示
                            </button>

                            <!-- モーダルの設定 -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <p></p>
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">日報登録</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container text-center">
                                                <div class="alert alert-primary" role="alert">
                                                    11/1(水)
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="出庫メーター">
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="出庫">
                                                            <span class="input-group-text" id="basic-addon1">打刻</span>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="入庫メーター">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="入庫">
                                                            <span class="input-group-text" id="basic-addon1">打刻</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="アワメーター始">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="アワメーター終">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-sm">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="休憩">


                                                        </div>
                                                    </div>
                                                    <div class="mb-3 pt-3">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="業務内容"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type=" button" class="btn btn-primary text-white rounded-pill px-5">登録</button>
                                        </div><!-- /.modal-footer -->
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </div>
                    </form>



                </form>
            </body>
        </div>
    </body>






    <script src="./js/jquery-3.5.1.min.js"></script>

    <!-- これがないとナビゲーションバーが展開しない -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Bundle with Popper.js -->
    <script src="./js/jbvalidator.js"></script>
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