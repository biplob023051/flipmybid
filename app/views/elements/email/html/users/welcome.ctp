<p><?php echo sprintf(__('Hi %s!', true), $data['User']['first_name']); ?></p>

<p><?php echo sprintf(__('Thank you for signing up to %s!', true), $appConfigurations['name']); ?></p>

<p><?php __('In order to activate your account please click on the following link:'); ?><br />
<a href="<?php echo $data['User']['activate_link'];?>" title="Activate"><?php echo $data['User']['activate_link'];?></a>
</p>

<p><?php __('Regards,'); ?><br />
<?php echo sprintf(__('The %s Team', true), $appConfigurations['name']); ?></p>