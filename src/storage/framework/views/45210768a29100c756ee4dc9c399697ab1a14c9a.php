<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
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
        <div class="admin__title">
            <h1>ユーザーリスト</h1>
        </div>

        <a class="top-btn" href="<?php echo e(route('admin.messages')); ?>">コメント一覧へ</a>

        <table border="1">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>作成日</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->created_at); ?></td>
                    <td>

                        <a href="<?php echo e(route('admin.mail', ['user_id' => $user->id])); ?>">メール作成</a>
                    </td>
                    <td>
                        <form action="<?php echo e(route('admin.delete', $user->id)); ?>" method="POST" style="display:inline;" onsubmit="confirmDeletion(event)">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/admin.blade.php ENDPATH**/ ?>