<?php echo sprintf(__('Hi %s', true), $data['User']['first_name']);?>,

<?php echo sprintf(__('Your password has been reset at %s.', true), $appConfigurations['name']);?>

<?php __('Your login details are');?>:
<?php __('Username');?>: <?php echo $data['User']['username'];?>

<?php __('Password');?>: <?php echo $data['User']['before_password'];?>

<?php __('We recommend you change your password when you login.');?>

<?php __('Thank You');?>
<?php echo $appConfigurations['name'];?>
