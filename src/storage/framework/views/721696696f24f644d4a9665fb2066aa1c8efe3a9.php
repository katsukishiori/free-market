<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/product_list.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<body>
    <div class="area">
        <div class="tab-container">
            <input type="radio" name="tab_name" id="tab1" checked>
            <label class="tab_class" for="tab1">おすすめ</label>
            <input type="radio" name="tab_name" id="tab2">
            <label class="tab_class" for="tab2">マイリスト</label>
        </div>

        <div class="content_class" id="content1">
            <div class="image-container">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('item.detail', ['item_id' => $item->id])); ?>">
                    <img src="<?php echo e(asset('storage/images/' . $item->img_url)); ?>" alt="<?php echo e($item->name); ?>の画像">
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="content_class" id="content2">
            <div class="image-container">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
    
                $isLiked = $item->likes()->where('user_id', auth()->id())->exists();
                ?>
                <?php if($isLiked): ?>
                <a href="<?php echo e(route('item.detail', ['item_id' => $item->id])); ?>">
                    <img src="<?php echo e(asset('storage/images/' . $item->img_url)); ?>" alt="<?php echo e($item->name); ?>の画像">
                </a>
                <?php endif; ?>
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
    <?php $__env->stopSection(); ?>
</body>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/product_list.blade.php ENDPATH**/ ?>