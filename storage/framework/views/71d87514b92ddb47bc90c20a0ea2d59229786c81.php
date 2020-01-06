# Info

Backend is developed using [Laravel 5.5](https://laravel.com/docs) framework
and APIs are developed following REST principles. For authentication, we are using
firebase. You will need to send the token recieved from firebase in `Authorization` 
header as `Bearer {token}` for authentication purpose.
<?php if($showPostmanCollectionButton): ?>
[Get Postman Collection](<?php echo e(url($outputPath.'/collection.json')); ?>)
<?php endif; ?>