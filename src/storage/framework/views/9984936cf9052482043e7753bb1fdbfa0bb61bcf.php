<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/update_profile.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/destyle.css')); ?>">
</head>

<body>

    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <div class="left-section">
                    <a class="header__logo" href="/">
                        COACHTECH
                    </a>
                    <div class="form__input--text">
                        <input type="password" name="password" placeholder="なにをお探しですか?" />
                    </div>
                </div>
                <div class="right-section">
                    <nav class="nav">
                        <ul class="header-nav">
                            <?php if(auth()->guard()->guest()): ?> <!-- ログインしていない場合に表示 -->
                            <li class="header-nav__item">
                                <a class="header-nav__link--login" href="/login">ログイン</a>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--register" href="/register">会員登録</a>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--item" href="/sell">出品</a>
                            </li>
                            <?php else: ?> <!-- ログインしている場合に表示 -->
                            <li class="header-nav__item">
                                <form class="form" action="/logout" method="post">
                                    <?php echo csrf_field(); ?>
                                    <button class="header-nav__button">ログアウト</button>
                                </form>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--mypage" href="/mypage">マイページ</a>
                            </li>
                            <li class="header-nav__item">
                                <a class="header-nav__link--item" href="/sell">出品</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <?php echo e(Session::get('success')); ?>

    </div>
    <?php endif; ?>

    <div class="content">

        <form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="profile-title">
                <h1>プロフィール設定</h1>
            </div>

            <div class="user-image">
                <figure class="icon-circle">
                    <img id="imagePreview" src="<?php echo e(asset('storage/images/' . ($imgUrl ?? 'default.jpg'))); ?>" alt="プロフィール画像">
                </figure>
                <input type="file" id="fileInput" name="image" onchange="updateFileName()">
                <label for="fileInput" class="custom-file-label" id="fileLabel">画像を選択する</label>
            </div>

            <script>
                function updateFileName() {
                    var fileInput = document.getElementById('fileInput');
                    var fileLabel = document.getElementById('fileLabel');
                    var fileName = fileInput.files[0] ? fileInput.files[0].name : '画像を選択する';
                    fileLabel.textContent = fileName;

                    var file = fileInput.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imagePreview = document.getElementById('imagePreview');
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                }
            </script>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">ユーザー名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--content">
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name ?? '')); ?>">
                    </div>
                    <div class="form__error">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php echo e($message); ?>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">郵便番号</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--content">
                        <input type="text" name="postcode" value="<?php echo e(old('postcode', $profile->postcode ?? '')); ?>">
                    </div>
                    <div class="form__error">
                        <?php $__errorArgs = ['postcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php echo e($message); ?>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--content">
                        <input type="text" name="address" value="<?php echo e(old('address', $profile->address ?? '')); ?>">
                    </div>
                    <div class="form__error">
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php echo e($message); ?>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--content">
                        <input type="text" name="building" value="<?php echo e(old('building', $profile->building ?? '')); ?>">
                    </div>
                    <div class="form__error">
                        <?php $__errorArgs = ['building'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php echo e($message); ?>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form__button--renew">
                <button class="form__button-submit" type="submit">更新する</button>
            </div>
        </form>
    </div>


</body>


</html><?php /**PATH /var/www/resources/views/update_profile.blade.php ENDPATH**/ ?>