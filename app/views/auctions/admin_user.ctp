<?php
$html->addCrumb('Manage Users', '/admin/users');
if ($user['Winner']['autobidder'] == 0) :
    $html->addCrumb('Users', '/admin/users');
    $html->addCrumb($user['Winner']['username'], '/admin/users/view/' . $user['Winner']['id']);
else:
    $html->addCrumb('Auto Bidders', '/admin/users/autobidders');
    $html->addCrumb($user['Winner']['username'], '/admin/users/autobidder_edit/' . $user['Winner']['id']);
endif;

$html->addCrumb('Won Auctions', '/admin/auctions/user/' . $user['Winner']['id']);
echo $this->element('admin/crumb');
?>

<div class="auctions index">

    <h2><?php __('Won Auctions'); ?></h2>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('ID', 'Auction.id'); ?></th>
                    <th><?php echo $paginator->sort('Title', 'Product.title'); ?></th>
                    <th><?php echo $paginator->sort('end_time'); ?></th>
                    <th><?php echo $paginator->sort('Final Price', 'price'); ?></th>
                    <th><?php echo $paginator->sort('Status', 'Status.name'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($auctions as $auction):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $auction['Auction']['id']; ?>
                        </td>
                        <td>
                            <?php echo $auction['Product']['title']; ?>
                        </td>
                        <td>
                            <?php echo $time->nice($auction['Auction']['end_time']); ?>
                        </td>
                        <td>
                            <?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
                        </td>
                        <td>
                            <?php if (!empty($auction['Status']['name'])) : ?>
                                <?php echo $auction['Status']['name']; ?>
                            <?php elseif (!empty($auction['Auction']['closed'])): ?>
                                <?php if (!empty($auction['Winner']['autobidder'])) : ?>
                                    Shipped & Completed
                                <?php else : ?>
                                    Closed
                                <?php endif; ?>
                            <?php elseif ($auction['Auction']['end_time'] > time()): ?>
                                Coming Soon
                            <?php else : ?>
                                Live
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('View', true), array('admin' => false, 'action' => 'view', $auction['Auction']['id']), array('target' => '_blank')); ?>
                            <?php if ((!empty($auction['Winner']['id'])) && ($auction['Winner']['autobidder'] == 0)) : ?>
                                / <?php echo $html->link(__('More Information', true), array('action' => 'winner', $auction['Auction']['id'])); ?>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('This user has not won any auctions yet.'); ?></p>
    <?php endif; ?>
</div>

<div class="actions">
    <ul>
        <?php echo $this->element('admin/user_links', array('id' => $user['Winner']['id'])); ?>
    </ul>
</div>