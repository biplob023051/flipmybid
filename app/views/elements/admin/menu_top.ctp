<div class="top-links">
    <ul>
        <li><?php echo $html->link('View Site', '/', array('target' => '_blank'));?></li>
        <li><?php //echo $html->link('Contact Innosoft', 'http://www.innosoft.co.nz', array('target' => '_blank'));?></li>
        <li><?php echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false));?></li>
    </ul>
    <div class="clear"></div>
</div>
