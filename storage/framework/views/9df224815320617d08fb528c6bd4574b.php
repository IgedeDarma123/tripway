<?php if($paginator->hasPages()): ?>
<div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">

    
    <div style="font-size:13px; color:#64748b;">
        Menampilkan <strong><?php echo e($paginator->firstItem()); ?></strong> - <strong><?php echo e($paginator->lastItem()); ?></strong>
        dari <strong><?php echo e($paginator->total()); ?></strong> data
    </div>

    
    <div style="display:flex; gap:4px; align-items:center;">

        
        <?php if($paginator->onFirstPage()): ?>
            <span style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#cbd5e1; font-size:13px; cursor:not-allowed;">
                <i class="fas fa-chevron-left"></i>
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#1B3A4B; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                <i class="fas fa-chevron-left"></i>
            </a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span style="padding:6px 10px; font-size:13px; color:#94a3b8;">...</span>
            <?php endif; ?>
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span style="padding:6px 12px; border-radius:8px; background:#1B3A4B; color:white; font-size:13px; font-weight:700;"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#475569; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#1B3A4B; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                <i class="fas fa-chevron-right"></i>
            </a>
        <?php else: ?>
            <span style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#cbd5e1; font-size:13px; cursor:not-allowed;">
                <i class="fas fa-chevron-right"></i>
            </span>
        <?php endif; ?>

    </div>
</div>
<?php endif; ?>
<?php /**PATH D:\tripway\tripway\resources\views/vendor/pagination/admin.blade.php ENDPATH**/ ?>