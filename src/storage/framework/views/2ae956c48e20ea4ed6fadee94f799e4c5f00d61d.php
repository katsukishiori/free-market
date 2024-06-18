<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACH TECH</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/sanitize.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/messages.css')); ?>">

    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    <div class="container">
        <h1 class="message-title">コメント一覧</h1>

        <form class="form" method="GET" action="<?php echo e(route('admin.messages')); ?>" class="search-form">
            <div class="form-group">
                <input type="text" name="user" id="user" class="form-control" placeholder=ユーザー名で検索 value="<?php echo e(request('user')); ?>">
            </div>
            <div class="form-group">
                <input type="text" name="item" id="item" class="form-control" placeholder=商品名で検索 value="<?php echo e(request('item')); ?>">
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>

        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemComments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $item = $itemComments->first()->item; ?>
        <h2 class="item-name"><?php echo e($item->name); ?></h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ユーザー名</th>
                    <th>コメント</th>
                    <th>送信日時</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $itemComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($comment->user->name); ?></td>
                    <td><?php echo e($comment->comment); ?></td>
                    <?php if($comment->created_at): ?>
                    <td><?php echo e($comment->created_at->format('Y-m-d H:i')); ?></td>
                    <?php else: ?>
                    <td>NULL</td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html><?php /**PATH /var/www/resources/views/messages.blade.php ENDPATH**/ ?>