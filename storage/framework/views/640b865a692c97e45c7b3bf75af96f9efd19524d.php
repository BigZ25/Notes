<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css?v='.filemtime(public_path('css/app.css')))); ?>">
</head>
<body>
<div id="app">
    <app></app>
</div>
<script type="text/javascript" src="<?php echo e(asset('js/app.js?v='.filemtime(public_path('js/app.js')))); ?>"></script>
<?php echo csrf_field(); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>