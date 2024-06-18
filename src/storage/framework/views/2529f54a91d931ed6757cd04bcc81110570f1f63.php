<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/comment.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/sanitize.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<body>

    <div class="flex">
        <div class="box">
            <div class="image-container">
                <img src="/img/<?php echo e($item->img_url); ?>" alt="<?php echo e($item->name); ?>の画像">
            </div>
        </div>
        <div class="box">
            <div class="item-name">
                <h1><?php echo e($item->name); ?></h1>
                <p>COACHTECH</p>
            </div>
            <div class="item-price">
                <p>¥<?php echo e(number_format($item->price)); ?>(値段)</p>
            </div>
            <div class="button-container">
                <form action="<?php echo e(route('like', ['item_id' => $item->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="like-btn">
                        <i id="heartIcon<?php echo e($item->id); ?>" class="fa-regular fa-star like-icon" style="color: <?php echo e($item->isLiked ? 'red' : '#'); ?>"></i>
                        <span class="like-count"><?php echo e($item->likes->count()); ?></span>
                    </button>
                </form>

                <script>
                    function toggleFavorite(event, itemId) {
                        event.preventDefault();

                        var heartIcon = document.getElementById('heartIcon' + itemId);
                        var isLiked = heartIcon.style.color === 'red';

                        fetch('/like/toggle/' + itemId, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                },
                                body: JSON.stringify({
                                    isLiked: !isLiked
                                })
                            })
                            .then(response => {
                                if (response.ok) {
                                    // レスポンスが正常な場合、アイコンの色を変更します
                                    heartIcon.style.color = isLiked ? '#EEEEEE' : 'red';
                                    return response.json();
                                }
                                throw new Error('いいねの状態を変更できませんでした');
                            })
                            .then(data => {
                                // 応答データを処理します（必要に応じて）
                            })
                            .catch(error => {
                                console.error('エラーが発生しました:', error);
                            });
                    }
                </script>

                <form action="/item/comment/<?php echo e($item->id); ?>" method="GET">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="comment-btn">
                        <i class="fa-regular fa-comment"></i>
                        <span class="comment-count"><?php echo e($item->comments_count); ?></span>
                    </button>
                    </button>
                </form>
            </div>

            <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="evaluation-item">
                <div class="evaluation-name">
                    <figure class="icon-circle">
                        <?php if($comment->user && $comment->user->profile && $comment->user->profile->img_url): ?>
                        <img src="<?php echo e(asset('storage/images/' . $comment->user->profile->img_url)); ?>" alt="">
                        <?php else: ?>
                        <div class="default-img"></div>
                        <?php endif; ?>
                    </figure>
                    <h4><?php echo e($comment->user->name); ?></h4>
                </div>
                <div class="evaluation-comment">
                    <?php echo e($comment->comment); ?>


                    <?php if($comment->user_id === Auth::id()): ?>
                    <form action="<?php echo e(route('comment.destroy', ['item' => $item->id, 'comment' => $comment->id])); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" onclick="return confirm('本当にこのコメントを削除しますか？');">削除</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            <div class="comment">
                <p>商品へのコメント</p>
                <form action="<?php echo e(route('comment', ['item_id' => $item->id])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <textarea name="comment" cols="40" rows="7"></textarea>
                    <div class="form__error">
                        <?php $__errorArgs = ['comment'];
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

                    <div class="form__button--comment">
                        <button class="form__button-submit" type="submit">コメントを送信する</button>
                    </div>
                </form>
            </div>
        </div>
</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/comment.blade.php ENDPATH**/ ?>