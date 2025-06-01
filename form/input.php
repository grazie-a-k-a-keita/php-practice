<?php

session_start();

require_once "validation.php";

header("X-FRAME-OPTIONS: DENY");

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

// if (!empty($_POST)) {
//   echo "<pre>";
//   var_dump($_POST);
//   echo "</pre>";
//   echo "<hr>";
// }

$pageFlag = 0;
$errors = validation($_POST);

if (!empty($_POST["btn_confirm"]) && empty($errors)) {
  $pageFlag = 1;
}
if (!empty($_POST["btn_submit"])) {
  $pageFlag = 2;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  <!-- 入力画面 -->
  <?php if ($pageFlag === 0) : ?>
    <?php
    if (!isset($_SESSION["csrfToken"])) {
      $_SESSION["csrfToken"] = bin2hex(random_bytes(32));
    }

    $token = $_SESSION["csrfToken"];
    ?>

    <div class="container my-5">
      <?php if (!empty($errors) && !empty($_POST["btn_confirm"])) : ?>
        <ul class="text-danger">
          <?php foreach ($errors as $error) {
            echo "<li>" . $error . "</li>";
          } ?>
        </ul>
      <?php endif; ?>

      <form method="POST" action="input.php">
        <div class="mb-3">
          <label for="name" class="form-label">氏名</label>
          <input type="text" class="form-control" name="name" id="name" value="<?php if (!empty($_POST["name"])) {
                                                                                  echo h($_POST["name"]);
                                                                                } ?>">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">メールアドレス</label>
          <input type="text" class="form-control" name="email" id="email" value="<?php if (!empty($_POST["email"])) {
                                                                                    echo h($_POST["email"]);
                                                                                  } ?>">
        </div>
        <div class="mb-3">
          <label for="url" class="form-label">ホームページ</label>
          <input type="text" class="form-control" name="url" id="url" value="<?php if (!empty($_POST["url"])) {
                                                                                echo h($_POST["url"]);
                                                                              } ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">性別</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender1" value="0" <?php if (isset($_POST["gender"]) && $_POST["gender"] === "0") {
                                                                                                echo "checked";
                                                                                              } ?>>
            <label class="form-check-label" for="gender1">
              男性
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender2" value="1" <?php if (isset($_POST["gender"]) && $_POST["gender"] === "1") {
                                                                                                echo "checked";
                                                                                              } ?>>
            <label class="form-check-label" for="gender2">
              女性
            </label>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="age">年齢</label>
          <select class="form-select" aria-label="Default select example" id="age" name="age">
            <option value="">選択してください</option>
            <option value="1" <?php if (isset($_POST["age"]) && $_POST["age"] === "1") {
                                echo "selected";
                              } ?>>～19歳</option>
            <option value="2" <?php if (isset($_POST["age"]) && $_POST["age"] === "2") {
                                echo "selected";
                              } ?>>20歳～29歳</option>
            <option value="3" <?php if (isset($_POST["age"]) && $_POST["age"] === "3") {
                                echo "selected";
                              } ?>>30歳～39歳</option>
            <option value="4" <?php if (isset($_POST["age"]) && $_POST["age"] === "4") {
                                echo "selected";
                              } ?>>40歳～49歳</option>
            <option value="5" <?php if (isset($_POST["age"]) && $_POST["age"] === "5") {
                                echo "selected";
                              } ?>>50歳～59歳</option>
            <option value="6" <?php if (isset($_POST["age"]) && $_POST["age"] === "6") {
                                echo "selected";
                              } ?>>60歳～</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="contact" class="form-label">お問い合わせ内容</label>
          <textarea class="form-control" id="contact" name="contact" rows="3"><?php if (!empty($_POST["contact"])) {
                                                                                echo h($_POST["contact"]);
                                                                              } ?></textarea>
        </div>
        <div class="mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="caution" name="caution">
            <label class="form-check-label" for="caution">
              注意事項のチェック
            </label>
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <input class="btn btn-primary" type="submit" name="btn_confirm" value="確認する">
        </div>

        <input type="hidden" name="csrf" value="<?php echo $token; ?>">
      </form>
    </div>
  <?php endif; ?>

  <!-- 確認画面 -->
  <?php if ($pageFlag === 1) : ?>
    <?php if ($_POST["csrf"] === $_SESSION["csrfToken"]) : ?>
      <div class="container my-5">
        <form method="POST" action="input.php">
          <p>氏名: <?php
                  echo h($_POST["name"]);
                  ?></p>
          <p>メールアドレス: <?php
                      echo h($_POST["email"]);
                      ?></p>
          <p>ホームページ: <?php
                      echo h($_POST["url"]);
                      ?></p>
          <p>性別: <?php
                  if ($_POST["gender"] === "0") {
                    echo "男性";
                  }
                  if ($_POST["gender"] === "1") {
                    echo "女性";
                  }
                  ?></p>
          <p>年齢: <?php
                  if ($_POST["age"] === "1") {
                    echo "～19歳";
                  } elseif ($_POST["age"] === "2") {
                    echo "20歳～29歳";
                  } elseif ($_POST["age"] === "3") {
                    echo "30歳～39歳";
                  } elseif ($_POST["age"] === "4") {
                    echo "40歳～49歳";
                  } elseif ($_POST["age"] === "5") {
                    echo "50歳～59歳";
                  } elseif ($_POST["age"] === "6") {
                    echo "60歳～";
                  }
                  ?></p>
          <p>お問い合わせ内容: <?php
                        echo h($_POST["contact"]);
                        ?></p>

          <div class="d-flex justify-content-end gap-3">
            <input class="btn btn-secondary" type="submit" name="back" value="戻る">
            <input class="btn btn-primary" type="submit" name="btn_submit" value="送信する">
          </div>

          <input type="hidden" name="name" value="<?php echo h($_POST["name"]); ?>">
          <input type="hidden" name="email" value="<?php echo h($_POST["email"]); ?>">
          <input type="hidden" name="url" value="<?php echo h($_POST["url"]); ?>">
          <input type="hidden" name="gender" value="<?php echo h($_POST["gender"]); ?>">
          <input type="hidden" name="age" value="<?php echo h($_POST["age"]); ?>">
          <input type="hidden" name="contact" value="<?php echo h($_POST["contact"]); ?>">
          <input type="hidden" name="caution" value="<?php echo h($_POST["caution"]); ?>">
          <input type="hidden" name="csrf" value="<?php echo h($_POST["csrf"]); ?>">
        </form>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <!-- 完了画面 -->
  <?php if ($pageFlag === 2) : ?>
    <?php if ($_POST["csrf"] === $_SESSION["csrfToken"]) : ?>

      <?php
      require "../mainte/insert.php";
      insertContacts($_POST);
      ?>

      <div class="container my-5">
        <p>送信が完了しました</p>
      </div>
      <?php unset($_SESSION["csrfToken"]); ?>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>
