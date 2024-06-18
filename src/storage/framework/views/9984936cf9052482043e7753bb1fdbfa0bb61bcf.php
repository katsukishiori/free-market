<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/update_profile.css')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(Session::has('success')): ?>
<div class="alert alert-success">
    <?php echo e(Session::get('success')); ?>

</div>
<?php endif; ?>
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
            <div class="form__input--text">
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
            <div class="form__input--text">
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
            <div class="form__input--text">
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
            <div class="form__input--text">
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

</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/update_profile.blade.php ENDPATH**/ ?>