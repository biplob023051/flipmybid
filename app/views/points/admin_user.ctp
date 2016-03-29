<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb(__('Rewards Points', true), '/admin/points/user/' . $user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Users Bid Points'); ?></h2>
<?php print("<p>Total Bid Points: " . $bidPoints . "</p>"); ?>

<h2><?php __('Users Rewards Points'); ?></h2>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Create a new reward transaction', true), array('action' => 'add', $user['User']['id'])); ?></li>
    </ul>
</div>

<?php if (!empty($points)): ?>
    <?php echo $this->element('admin/pagination'); ?>
    <div class="table-responsive">
        <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $paginator->sort('Date', 'Point.created'); ?></th>
                <th><?php echo $paginator->sort('description'); ?></th>
                <th><?php echo $paginator->sort('debit'); ?></th>
                <th><?php echo $paginator->sort('credit'); ?></th>
                <th class="actions"><?php __('Options'); ?></th>
            </tr>

            <tr>
                <td colspan="3"><strong><?php __('Current Balance'); ?></strong></td>
                <td><strong><?php echo $balance; ?></strong></td>
            </tr>
            <?php
            $i = 0;
            foreach ($points as $point):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td>
                        <?php echo $time->niceShort($point['Point']['created']); ?>
                    </td>
                    <td>
                        <?php echo $point['Point']['description']; ?>
                    </td>
                    <td>
                        <?php if ($point['Point']['debit'] > 0) : ?><?php echo $point['Point']['debit']; ?><?php else: ?>&nbsp;<?php endif; ?>
                    </td>
                    <td>
                        <?php if ($point['Point']['credit'] > 0) : ?><?php echo $point['Point']['credit']; ?><?php else: ?>&nbsp;<?php endif; ?>
                    </td>
                    <td>
                        <?php echo $html->link(__('Delete', true), array('action' => 'delete', $point['Point']['id']), null, sprintf(__('Are you sure you want to delete this translation?', true))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
    <p><?php __('This user has no reward points at the moment.'); ?></p>
<?php endif; ?>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Create a new reward transaction', true), array('action' => 'add', $user['User']['id'])); ?></li>
        <?php echo $this->element('admin/user_links', array('id' => $user['User']['id'])); ?>
    </ul>
</div>