<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/manager_list.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<script>
    function confirmDeletion(event) {
        if (!confirm('本当に削除しますか？')) {
            event.preventDefault();
        }
    }
</script>

<body>
    <div class="container">
        <div class="manager-list__title">
            <h1>ショップスタッフリスト</h1>
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>ショップ名</th>
                    <th>メールアドレス</th>
                    <th>作成日</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($manager->shop_name); ?></td>
                    <td><?php echo e($manager->user->email); ?></td>
                    <td><?php echo e($manager->created_at); ?></td>
                    <td>
                        <form action="<?php echo e(route('manager.delete', $manager->id)); ?>" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <a class="bottom__btn" href="<?php echo e(route('manager')); ?>">ショップスタッフ招待メール送信画面へ</a>
    </div>
</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/manager_list.blade.php ENDPATH**/ ?>