<?php if(!empty($data['Page']['message'])) : ?>
<?php echo $data['Page']['message']; ?>

<?php endif; ?>

<?php if(!empty($data['Page']['phone'])) : ?>
<?php __('Phone Number');?>: <?php echo $data['Page']['phone']; ?>

<?php endif; ?>

<?php if(!empty($ip_loc['country_name'])) : ?>
<?php if(!empty($ip_loc['city'])) : ?><?php echo $ip_loc['city']; ?>, <?php endif; ?><?php echo $ip_loc['country_name']; ?>

<?php endif; ?>

<?php if(!empty($data['Page']['username'])) : ?>
<?php __('Username');?>: <?php echo $data['Page']['username']; ?>

<?php __('Purchased before');?>: <?php if($data['Page']['purchased'] > 0) : ?>Yes<?php else : ?>No<?php endif; ?>

<?php __('Bid Balance');?>: <?php echo $data['Page']['balance']; ?>
<?php endif; ?>

