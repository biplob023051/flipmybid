<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="coupons index">
    <h2><?php __('Coupons'); ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('New Coupon', true), array('action' => 'add')); ?></li>
        </ul>
    </div>

    <?php if ($paginator->counter() > 0): ?>
        <p><?php echo $this->element('pagination'); ?></p>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('code'); ?></th>
                    <th><?php echo $paginator->sort('saving'); ?></th>
                    <th><?php echo $paginator->sort('coupon_type_id'); ?></th>
                    <th class="actions"><?php __('Actions'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($coupons as $coupon):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $coupon['Coupon']['code']; ?>
                        </td>
                        <td>
                            <?php if ($coupon['Coupon']['coupon_type_id'] == 1): ?>
                                <?php echo round($coupon['Coupon']['saving']); ?>%
                            <?php elseif ($coupon['Coupon']['coupon_type_id'] == 2): ?>
                                <?php echo $number->currency($coupon['Coupon']['saving'], $appConfigurations['currency']); ?>
                            <?php elseif ($coupon['Coupon']['coupon_type_id'] == 3): ?>
                                <?php echo round($coupon['Coupon']['saving']); ?><?php __('Bids'); ?>
                            <?php elseif ($coupon['Coupon']['coupon_type_id'] == 4): ?>
                                <?php echo round($coupon['Coupon']['saving']); ?>% <?php __('Free Bids'); ?>
                            <?php elseif ($coupon['Coupon']['coupon_type_id'] == 5): ?>
                                <?php echo sprintf(__('%d Free Rewards Points', true), round($coupon['Coupon']['saving'])); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $coupon['CouponType']['name']; ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('Edit', true), array('action' => 'edit', $coupon['Coupon']['id'])); ?>
                            <?php echo $html->link(__('Delete', true), array('action' => 'delete', $coupon['Coupon']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $coupon['Coupon']['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="actions">
            <ul>
                <li><?php echo $html->link(__('New Coupon', true), array('action' => 'add')); ?></li>
            </ul>
        </div>
        <p><?php echo $this->element('pagination'); ?></p>
    <?php else: ?>
        <?php __('There is no coupon at the moment', true); ?>
    <?php endif; ?>
</div>