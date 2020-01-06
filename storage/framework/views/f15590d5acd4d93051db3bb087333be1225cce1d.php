```javascript
const url = new URL("<?php echo e(rtrim($baseUrl, '/')); ?>/<?php echo e(ltrim($route['boundUri'], '/')); ?>");
<?php if(count($route['cleanQueryParameters'])): ?>

    let params = {
    <?php $__currentLoopData = $route['cleanQueryParameters']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parameter => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        "<?php echo e($parameter); ?>": "<?php echo e($value); ?>",
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
<?php endif; ?>

let headers = {
<?php $__currentLoopData = $route['headers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    "<?php echo e($header); ?>": "<?php echo e($value); ?>",
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(!array_key_exists('Accept', $route['headers'])): ?>
    "Accept": "application/json",
<?php endif; ?>
<?php if(!array_key_exists('Content-Type', $route['headers'])): ?>
    "Content-Type": "application/json",
<?php endif; ?>
}
<?php if(count($route['bodyParameters'])): ?>

let body = <?php echo json_encode($route['cleanBodyParameters'], JSON_PRETTY_PRINT); ?>

<?php endif; ?>

fetch(url, {
    method: "<?php echo e($route['methods'][0]); ?>",
    headers: headers,
<?php if(count($route['bodyParameters'])): ?>
    body: body
<?php endif; ?>
})
    .then(response => response.json())
    .then(json => console.log(json));
```
