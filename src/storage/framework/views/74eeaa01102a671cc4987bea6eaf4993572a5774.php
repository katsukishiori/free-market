<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/manager.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<body>
    <div class="container">
        <h1 class="manager-title">
            ショップスタッフ招待メール送信
        </h1>

        <?php if(Auth::id() === config('const.GUEST_USER_ID')): ?>
        <p class="text-danger">
            ※ゲストユーザーは、家族招待メールを送信できません。
        </p>
        <?php endif; ?>

        <div class="card my-4 shadow-sm">
            <div class="card-body">


                <?php if(session('status')): ?>
                <div class="card-text alert alert-success">
                    <?php echo e(session('status')); ?>

                </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('invite.email')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <input class="form-control" type="email" id="email" name="email" required placeholder="メールアドレスを入力" value="<?php echo e(old('email')); ?>" <?php echo e(Auth::id() === config('const.GUEST_USER_ID') ? 'readonly' : ''); ?>>
                        <p>※招待したいショップスタッフのメールアドレスを入力してください。</p>
                    </div>

                    <?php if(Auth::id() !== config('const.GUEST_USER_ID')): ?>
                    <button type="submit" class="submit-btn">
                        <b>送信する</b>
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <a class="bottom__btn " href="<?php echo e(route('manager.detail')); ?>">ショップスタッフ一覧へ</a>
    </div>





</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/manager.blade.php ENDPATH**/ ?>