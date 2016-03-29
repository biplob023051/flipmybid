<?php echo sprintf(__('Hi %s!', true), $data['User']['first_name']); ?>

<?php __('In order to activate your account please click on the following link:'); ?> <?php echo $data['User']['activate_link'];?>

<?php __('Regards,'); ?>
<?php echo sprintf(__('The %s Team', true), $appConfigurations['name']); ?>