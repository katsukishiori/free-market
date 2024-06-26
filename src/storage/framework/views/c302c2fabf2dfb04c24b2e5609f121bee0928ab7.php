<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/item.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<body>
    <div class="flex">
        <div class="box__left">
            <div class="image-container">
                <img src="<?php echo e(asset('storage/images/' . $item->img_url)); ?>" alt="<?php echo e($item->name); ?>の画像">
            </div>
        </div>
        <div class="box__right">
            <div class="item-name">
                <h1><?php echo e($item->name); ?></h1>
                <?php if(isset($roleUser) && $roleUser->manager): ?>
                <p><?php echo e($roleUser->manager->shop_name); ?></p>
                <?php else: ?>
                <p></p>
                <?php endif; ?>
            </div>
            <div class="item-price">
                <p>¥<?php echo e(number_format($item->price)); ?>(値段)</p>
            </div>

            <!--色変える <form action="<?php echo e(route('like', ['item_id' => $item->id])); ?>" method="POST" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-primary like-button" onclick="toggleFavorite(event, '<?php echo e($item->id); ?>')">
                    <i id="heartIcon<?php echo e($item->id); ?>" class="fas fa-star" style="color: <?php echo e($item->isLiked ? 'orange' : '#EEEEEE'); ?>; font-size: 30px;"></i>
                </button>
            </form>
            <span id="likeCount<?php echo e($item->id); ?>" class="like-count"><?php echo e($item->likes->count()); ?></span>

            <script>
                async function toggleFavorite(event, itemId) {
                    event.preventDefault();

                    var heartIcon = document.getElementById('heartIcon' + itemId);
                    var likeCount = document.getElementById('likeCount' + itemId);

                    if (heartIcon.style.color === 'red') {
                        heartIcon.style.color = '#EEEEEE';
                        likeCount.textContent = parseInt(likeCount.textContent) - 1; // カウントを減らす
                        await sendFavoriteStatusToServer(itemId, false);
                    } else {
                        heartIcon.style.color = 'red';
                        likeCount.textContent = parseInt(likeCount.textContent) + 1; // カウントを増やす
                        await sendFavoriteStatusToServer(itemId, true);
                    }
                }

                async function sendFavoriteStatusToServer(itemId, isFavorite) {
                    try {
                        const response = await fetch('/favorites/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            },
                            body: JSON.stringify({
                                itemId: itemId,
                                isFavorite: isFavorite,
                            }),
                        });

                        if (response.ok) {
                            console.log('お気に入りの状態がサーバーに送信されました');
                        } else {
                            console.error('お気に入りの状態の送信に失敗しました');
                        }
                    } catch (error) {
                        console.error('エラーが発生しました', error);
                    }
                }
            </script> -->
            <div class="button-container">
                <form action="<?php echo e(route('like', ['item_id' => $item->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="like-btn">
                        <i id="heartIcon<?php echo e($item->id); ?>" class="fa-regular fa-star like-icon" style="color: <?php echo e($item->isLiked ? 'red' : '#'); ?>"></i>
                        <span class="like-count"><?php echo e($item->likes->count()); ?></span>
                    </button>
                </form>

                <form action="/item/comment/<?php echo e($item->id); ?>" method="GET">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="comment-btn">
                        <i class="fa-regular fa-comment"></i>
                        <span class="comment-count"><?php echo e($item->comments_count); ?></span>
                    </button>
                    </button>
                </form>
            </div>

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

            <div class="form__button">
                <a href="/purchase/<?php echo e($item->id); ?>" class="form__button-submit">購入する</a>
            </div>
            <div class="item-description">
                <h2>商品説明</h2>
                <p><?php echo nl2br(e($item->description)); ?></p>
            </div>
            <div class="item-information">
                <h2>商品の情報</h2>
                <table>
                    <tr>
                        <th>カテゴリー</th>
                        <td><?php echo e($category->category); ?></td>
                    </tr>
                    <tr>
                        <th>商品の状態</th>
                        <td><?php echo e($item->condition->condition); ?></td>
                    </tr>
                </table>
            </div>
        </div>
</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/item.blade.php ENDPATH**/ ?>