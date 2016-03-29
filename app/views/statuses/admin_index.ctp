<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Auction Statuses', true), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Auction Statuses'); ?></h2>

<?php if (!empty($statuses)): ?>

    <?php echo $this->element('admin/pagination'); ?>
    <div class="table-responsive">
        <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $paginator->sort('name'); ?></th>
                <th><?php echo $paginator->sort('message'); ?></th>
                <th class="actions"><?php __('Options'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($statuses as $status):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td><?php echo $status['Status']['name']; ?></td>
                    <td><?php echo $status['Status']['message']; ?></td>
                    <td class="actions">
                        <?php if ($this->requestAction('/settings/enabled/multi_languages')) : ?>
                            <?php echo $html->link(__('Edit', true), array('action' => 'translations', $status['Status']['id'])); ?>
                        <?php else : ?>
                            <?php echo $html->link(__('Edit', true), array('action' => 'edit', $status['Status']['id'])); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
    <p><?php __('There are no statuses at the moment.'); ?></p>
<?php endif; ?>
