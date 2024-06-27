<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/mypage.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<body>
    <div class="user-profile">
        <div class="user-info">
            <div class="user-name">
                <figure class="icon-circle">
                    <?php if($imgUrl): ?>
                    <img src="<?php echo e(asset('storage/images/' . $imgUrl)); ?>" alt="">
                    <?php else: ?>
                    <div class="default-img"></div>
                    <?php endif; ?>
                </figure>
                <?php if(Auth::check()): ?>
                <h1><?php echo e(Auth::user()->name); ?></h1>
                <?php endif; ?>
            </div>
            <a href="/mypage/profile">
                <button class="edit-profile-button">プロフィールを編集</button>
            </a>
        </div>
    </div>

    <div class="area">
        <div class="tab-container">
            <input type="radio" name="tab_name" id="tab1" checked>
            <label class="tab_class" for="tab1">出品した商品</label>
            <input type="radio" name="tab_name" id="tab2">
            <label class="tab_class" for="tab2">購入した商品</label>
        </div>

        <div class="content_class" id="content1">
            <div class="image-container">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <a href="<?php echo e(route('item.detail', ['item_id' => $item->id])); ?>">
                        <img src="<?php echo e(asset('storage/images/' . $item->img_url)); ?>" alt="<?php echo e($item->name); ?>の画像">
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="content_class" id="content2">
            <div class="image-container">
                <?php $__currentLoopData = $soldItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $soldItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <a href="<?php echo e(route('item.detail', ['item_id' => $soldItem->item->id])); ?>">
                        <img src="<?php echo e(asset('storage/images/' . $soldItem->item->img_url)); ?>" alt="<?php echo e($soldItem->item->name); ?>の画像">
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab_class');
            const contents = document.querySelectorAll('.content_class');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const target = this.getAttribute('for');

                    contents.forEach(content => {
                        content.style.display = 'none';
                    });

                    document.getElementById(`content${target.charAt(target.length - 1)}`).style.display = 'block';
                });
            });
        });
    </script>

    <div class="content_class">
        <div class="image-container">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <a href="<?php echo e(route('item.detail', ['item_id' => $item->id])); ?>">
                    <img src="<?php echo e(asset('storage/images/' . $item->img_url)); ?>" alt="<?php echo e($item->name); ?>の画像">
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="content_class">
        <div class="image-container">
            <?php $__currentLoopData = $soldItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $soldItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($soldItem->item): ?> <!-- 関連する item が存在する場合のみ表示 -->
            <div>
                <a href="<?php echo e(route('item.detail', ['item_id' => $soldItem->item->id])); ?>">
                    <img src="<?php echo e(asset('storage/images/' . $soldItem->item->img_url)); ?>" alt="<?php echo e($soldItem->item->name); ?>の画像">
                </a>
            </div>
            <?php else: ?>
            <p>関連するアイテムが見つかりません。</p>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab_class');
            const contents = document.querySelectorAll('.content_class');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const target = this.getAttribute('for');

                    contents.forEach(content => {
                        content.style.display = 'none';
                    });

                    document.getElementById(`content${target.charAt(target.length - 1)}`).style.display = 'block';
                });
            });
        });
    </script>

    <?php $__env->stopSection(); ?>
</body>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/mypage.blade.php ENDPATH**/ ?>