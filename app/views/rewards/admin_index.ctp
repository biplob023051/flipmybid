<?php
$html->addCrumb('Redeemed Rewards', '/admin/exchanges');
echo $this->element('admin/crumb');
?>

<div class="auctions index">

    <h2>Redeemed Rewards</h2>

    <?php if (!empty($statuses)): ?>
        View by status :
        <?php echo $form->create('Reward', array('action' => 'index')); ?>
        <?php echo $form->input('status_id', array('id' => 'selectStatus', 'selected' => $selected, 'options' => $statuses, 'label' => false)); ?>
        <?php echo $form->end(); ?>
    <?php endif; ?>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('Product', 'Product.title'); ?></th>
                    <th><?php echo $paginator->sort('User', 'User.username'); ?></th>
                    <th><?php echo $paginator->sort('Points', 'Reward.points'); ?></th>
                    <th><?php echo $paginator->sort('Date', 'Reward.created'); ?></th>
                    <th><?php echo $paginator->sort('Status', 'Status.name'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                $totalDue = 0;
                foreach ($rewards as $reward):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $html->link($reward['Product']['title'], array('controller' => 'products', 'action' => 'edit', $reward['Reward']['product_id'])); ?>
                        </td>
                        <td>
                            <?php echo $html->link($reward['User']['username'], array('controller' => 'users', 'action' => 'view', $reward['Reward']['user_id'])); ?>
                        </td>
                        <td><?php echo $reward['Reward']['points'] ?></td>
                        <td>
                            <?php echo $time->niceShort($reward['Reward']['created']); ?>
                        </td>
                        <td>
                            <?php if (!empty($reward['Status']['name'])) : ?>
                                <?php echo $reward['Status']['name']; ?>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('More Information', true), array('action' => 'view', $reward['Reward']['id'])); ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $reward['Reward']['id']), null, sprintf(__('Are you sure you want to delete this redeemed reward: %s?', true), $reward['Product']['title'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('There are no redeemed rewards at the moment.'); ?></p>
    <?php endif; ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ($('#selectStatus').length) {
            $('#selectStatus').change(function () {
                location.href = '/admin/rewards/index/' + $('#selectStatus').val();
            });
        }
    });
</script>