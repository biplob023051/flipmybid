<?php
$html->addCrumb('Products Purchased', '/admin/exchanges');
echo $this->element('admin/crumb');
?>

<div class="auctions index">

    <h2>Products Purchased</h2>

    <?php if (!empty($statuses)): ?>
        View by status :
        <?php echo $form->create('Exchange', array('action' => 'index')); ?>
        <?php echo $form->input('status_id', array('id' => 'selectStatus', 'selected' => $selected, 'options' => $statuses, 'label' => false)); ?>
        <?php echo $form->end(); ?>
    <?php endif; ?>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">

            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('Auction', 'Product.title'); ?></th>
                    <th><?php echo $paginator->sort('User', 'User.username'); ?></th>
                    <th><?php echo $paginator->sort('Price', 'Exchange.price'); ?></th>
                    <th><?php echo $paginator->sort('Date', 'Exchange.created'); ?></th>
                    <th><?php echo $paginator->sort('Status', 'Status.name'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                $totalDue = 0;
                foreach ($exchanges as $exchange):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $html->link($exchange['Auction']['Product']['title'], array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $exchange['Auction']['id']), array('target' => '_blank')); ?>
                        </td>
                        <td>
                            <?php echo $html->link($exchange['User']['username'], array('controller' => 'users', 'action' => 'view', $exchange['User']['id'])); ?>
                        </td>
                        <td><?php echo $number->currency($exchange['Exchange']['price'], $appConfigurations['currency']); ?></td>
                        <td>
                            <?php echo $time->niceShort($exchange['Exchange']['created']); ?>
                        </td>
                        <td>
                            <?php if (!empty($exchange['Status']['name'])) : ?>
                                <?php echo $exchange['Status']['name']; ?>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('View', true), array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $exchange['Auction']['id']), array('target' => '_blank')); ?>
                            / <?php echo $html->link(__('View Winner', true), array('action' => 'view', $exchange['Exchange']['id'])); ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $exchange['Exchange']['id']), null, sprintf(__('Are you sure you want to delete this exchange: %s?', true), $exchange['Auction']['Product']['title'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('There are no bid exchanges at the moment.'); ?></p>
    <?php endif; ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        if ($('#selectStatus').length) {
            $('#selectStatus').change(function () {
                location.href = '/admin/exchanges/index/' + $('#selectStatus').val();
            });
        }
    });
</script>