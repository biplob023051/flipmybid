<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
$html->addCrumb($auction['Product']['title'], '/admin/auctions/edit/' . $auction['Auction']['id']);
$html->addCrumb(__('Auction Increments', true), '/admin/increments/auction/' . $auction['Auction']['id']);
echo $this->element('admin/crumb');
?>

<div class="limits index">
    <h2><?php __('Auction Increments'); ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Add a new increment', true), array('action' => 'add', $auction['Auction']['id'])); ?></li>
        </ul>
    </div>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('Bid Increment', 'Increment.bid'); ?></th>
                    <th><?php echo $paginator->sort('Price Increment', 'Increment.price'); ?></th>
                    <th><?php echo $paginator->sort('Time Increment', 'Increment.time'); ?></th>
                    <th><?php echo $paginator->sort('Low Price', 'Increment.low_price'); ?></th>
                    <th><?php echo $paginator->sort('High Price', 'Increment.high_price'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($increments as $increment):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td><?php echo $increment['Increment']['bid']; ?> bids</td>
                        <td><?php echo $number->currency($increment['Increment']['price'], $appConfigurations['currency']); ?></td>
                        <td><?php echo $increment['Increment']['time']; ?> seconds</td>
                        <td><?php echo $number->currency($increment['Increment']['low_price'], $appConfigurations['currency']); ?></td>
                        <td><?php echo $number->currency($increment['Increment']['high_price'], $appConfigurations['currency']); ?></td>

                        <td class="actions">
                            <?php echo $html->link(__('Edit', true), array('action' => 'edit', $increment['Increment']['id'])); ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $increment['Increment']['id']), null, __('Are you sure you want to delete this increment?', true)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('There are no auction increments at the moment.'); ?></p>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Add a new increment', true), array('action' => 'add', $auction['Auction']['id'])); ?></li>
        </ul>
    </div>
</div>