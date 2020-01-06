<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
        <h3 style="color: green">
            <?php echo e(session('status')); ?>

        </h3>
    <?php endif; ?>
    <div class="title m-b-md">
        <?php if(env('APP_LOGO')): ?>
            <div><img src="<?php echo e(env('APP_LOGO')); ?>" /></div>
        <?php endif; ?>
        <?php echo e(config('app.name')); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.welcome', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>