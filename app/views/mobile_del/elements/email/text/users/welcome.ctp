<?php echo sprintf(__('Hi %s!', true), $data['User']['first_name']); ?>

<?php echo sprintf(__('Thank you for signing up to %s!', true), $appConfigurations['name']); ?>

<?php __('In order to activate your account please click on the following link:'); ?> <?php echo $data['User']['activate_link'];?>

<?php __('Regards,'); ?>
<?php echo sprintf(__('The %s Team', true), $appConfigurations['name']); ?>