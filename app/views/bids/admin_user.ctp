<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/' . $user['User']['id']);
$html->addCrumb(__('Bids', true), '/admin/bids/user/' . $user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Users Bids'); ?></h2>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Give a user a bid package (use when a payment wasn\'t credited)', true), array('controller' => 'payment_gateways', 'action' => 'add', $user['User']['id'])); ?></li>
        <li><?php echo $html->link(__('Create a manual bid transaction', true), array('action' => 'add', $user['User']['id'])); ?></li>
    </ul>
</div>
<div class="col-sm-8 col-sm-offset-2" id="bidsUser">
    <p>This user currently has <strong><?php echo $bidBalance; ?></strong> bids in their account.</p>

    <?php if ($this->requestAction('/settings/enabled/database_cleaner')) : ?>
        <h3>Their Bids - Last <?php echo $this->requestAction('/settings/get/bids_archive'); ?> days.</h3>
    <?php else : ?>
        <h3>Their Bids</h3>
    <?php endif; ?>

    <?php if (!empty($bids)): ?>
        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('Date', 'Bid.created'); ?></th>
                    <th><?php echo $paginator->sort('description'); ?></th>
                    <th><?php echo $paginator->sort('debit'); ?></th>
                    <th><?php echo $paginator->sort('credit'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($bids as $bid):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $time->niceShort($bid['Bid']['created']); ?>
                        </td>
                        <td>
                            <?php echo $bid['Bid']['description']; ?>
                            <?php if (!empty($bid['Bid']['auction_id'])) : ?>
                                placed on auction titled: <?php echo $html->link($bid['Auction']['Product']['title'], array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $bid['Bid']['auction_id']), array('target' => '_blank')); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($bid['Bid']['debit'] > 0) : ?><?php echo $bid['Bid']['debit']; ?><?php else: ?>&nbsp;<?php endif; ?>
                        </td>
                        <td>
                            <?php if ($bid['Bid']['credit'] > 0) : ?><?php echo $bid['Bid']['credit']; ?><?php else: ?>&nbsp;<?php endif; ?>
                        </td>
                        <td>
                            <?php echo $html->link(__('Delete', true), array('action' => 'delete', $bid['Bid']['id']), null, sprintf(__('Are you sure you want to delete this bid translation?', true))); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('This user has no bids at the moment.'); ?></p>
    <?php endif; ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Give a user a bid package (use when a payment wasn\'t credited)', true), array('controller' => 'payment_gateways', 'action' => 'add', $user['User']['id'])); ?></li>
        <li><?php echo $html->link(__('Create a manual bid transaction', true), array('action' => 'add', $user['User']['id'])); ?></li>
        <?php echo $this->element('admin/user_links', array('id' => $user['User']['id'])); ?>
    </ul>
</div>
