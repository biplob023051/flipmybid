<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
$html->addCrumb($auction['Product']['title'], '/admin/auctions/edit/' . $auction['Auction']['id']);
$html->addCrumb(__('Bid Buddies', true), '/admin/bidbuddies/auction/' . $auction['Auction']['id']);
echo $this->element('admin/crumb');
?>

    <h2><?php __('Bid Buddies on Auction:'); ?><?php echo $auction['Product']['title']; ?></h2>

<?php if (!empty($bidbutlers)): ?>
    <?php echo $this->element('admin/pagination'); ?>
    <div class="table-responsive">
        <table class="table table-condensed table-striped" class="results" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $paginator->sort('Username', 'User.username'); ?></th>
                <th><?php echo $paginator->sort('minimum_price'); ?></th>
                <th><?php echo $paginator->sort('maximum_price'); ?></th>
                <th><?php echo $paginator->sort('bids'); ?></th>
                <th><?php echo $paginator->sort('Date', 'created'); ?></th>
                <th class="actions"><?php __('Options'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($bidbutlers as $bidbutler):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td>
                        <?php echo $html->link($bidbutler['User']['username'], array('controller' => 'users', 'action' => 'view', $bidbutler['User']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $number->currency($bidbutler['Bidbutler']['minimum_price'], $appConfigurations['currency']); ?>
                    </td>
                    <td>
                        <?php echo $number->currency($bidbutler['Bidbutler']['maximum_price'], $appConfigurations['currency']); ?>
                    </td>
                    <td>
                        <?php echo $bidbutler['Bidbutler']['bids']; ?>
                    </td>
                    <td>
                        <?php echo $time->niceShort($bidbutler['Bidbutler']['created']); ?>
                    </td>
                    <td>
                        <?php echo $html->link(__('Delete', true), array('action' => 'delete', $bidbutler['Bidbutler']['id'], true), null, sprintf(__('Are you sure you want to delete this bid buddy?', true))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
    <p><?php __('This auction has no bid buddies at the moment.'); ?></p>
<?php endif; ?>