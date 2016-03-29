<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/' . $user['User']['id']);
$html->addCrumb(__('Bid Buddies', true), '/admin/bidbuddies/user/' . $user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Users Bid Buddies'); ?></h2>

<?php if (!empty($bidbutlers)): ?>
    <?php echo $this->element('admin/pagination'); ?>
    <div class="table-responsive">
        <table class="table table-condensed table-striped" class="results" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $paginator->sort('Auction', 'Auction.title'); ?></th>
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
                        <?php echo $html->link($bidbutler['Auction']['Product']['title'], array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $bidbutler['Bidbutler']['auction_id']), array('target' => '_blank')); ?>
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
                        <?php echo $html->link(__('Delete', true), array('action' => 'delete', $bidbutler['Bidbutler']['id']), null, sprintf(__('Are you sure you want to delete this bid buddy?', true))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
    <p><?php __('This user has no bid buddies at the moment.'); ?></p>
<?php endif; ?>

<div class="actions">
    <ul>
        <?php echo $this->element('admin/user_links', array('id' => $user['User']['id'])); ?>
    </ul>
</div>
