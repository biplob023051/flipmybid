<?php
$html->addCrumb('Manage Auctions', '/admin/actions');
$html->addCrumb('Packages Purchased', '/admin/accounts');
echo $this->element('admin/crumb');
?>

    <h1><?php __('Packages Purchased'); ?></h1>
<?php if (!empty($accounts)): ?>
    <?php echo $this->element('pagination'); ?>
    <div class="table-responsive">
        <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $paginator->sort('Date', 'created'); ?></th>
                <th><?php echo $paginator->sort('Description', 'Account.name'); ?></th>
                <th><?php echo $paginator->sort('Amount', 'Auction.price'); ?></th>
                <th><?php echo $paginator->sort('Username', 'User.username'); ?></th>
            </tr>
            <?php
            foreach ($accounts as $account):
                ?>
                <tr>
                    <td>
                        <?php echo $time->niceShort($account['Account']['created']); ?>
                    </td>
                    <td>
                        <?php echo $account['Account']['name']; ?>
                        <?php if (!empty($account['Account']['auction_id'])) : ?>
                            <a target="_blank"
                               href="/auction/<?php echo $account['Account']['auction_id']; ?>"><?php __('View this Auction'); ?></a>
                        <?php elseif (!empty($account['Account']['bids'])) : ?>
                            - <?php echo sprintf(__('%d Bids Purchased', true), $account['Account']['bids']); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $number->currency($account['Account']['price'], $appConfigurations['currency']); ?>
                    </td>
                    <td>
                        <?php echo $html->link($account['User']['username'], array('controller' => 'users', 'action' => 'view', $account['User']['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php echo $this->element('pagination'); ?>

<?php else: ?>
    <p><?php __('There no account transactions at the moment.'); ?></p>
<?php endif; ?>