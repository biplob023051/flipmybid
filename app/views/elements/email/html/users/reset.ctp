<p><?php echo sprintf(__('Hi %s,', true), $data['User']['first_name']);?></p>

<p><?php echo sprintf(__('Your password has been reset at %s.', true), $appConfigurations['name']);?></p>

<p><?php __('Your login details are');?>:<br />
<?php __('Username');?>: <?php echo $data['User']['username'];?><br />
<?php __('Password');?>: <?php echo $data['User']['before_password'];?>
</p>

<?php __('We recommend you change your password when you login.');?>

<p><?php __('Thank You');?><br/>
<?php echo $appConfigurations['name'];?></p>
