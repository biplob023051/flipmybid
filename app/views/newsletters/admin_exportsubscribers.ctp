<?php
header("Content-type:application/vnd.ms-excel");
header("Content-disposition:attachment;filename=newsletter-users.csv");
?>
"Username","First Name","Last Name","Email"
<?php foreach($users as $user) : ?>
<?php echo str_replace('"' , '""', $user['User']['username']); ?>,<?php echo str_replace('"' , '""', $user['User']['first_name']); ?>,<?php echo str_replace('"' , '""', $user['User']['last_name']); ?>,<?php echo $user['User']['email']; ?>

<?php endforeach; ?>