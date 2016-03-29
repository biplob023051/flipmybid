<?php
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="newsletters index">
    <h2><?php __('Newsletters'); ?></h2>

    <?php echo $html->link(__('Export subsribers (.csv)', true), array('action' => 'exportsubscribers')); ?>

    <?php if (!empty($newsletterRunning)) : ?>
        <p><strong>There is a newsletter running at the moment. The newsletter still
                has <?php echo $newsletterRunning; ?> emails to send. It is recommended that you to NOT send another
                newsletter yet. If you need to stop this newsletter from sending <a href="/admin/newsletters/stop">click
                    here</a>.</strong></p>
    <?php endif; ?>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('subject'); ?></th>
                    <th><?php echo $paginator->sort('sent'); ?></th>
                    <th><?php echo $paginator->sort('Date Sent', 'modified'); ?></th>
                    <th><?php echo $paginator->sort('created'); ?></th>
                    <th class="actions"><?php __('Actions'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($newsletters as $newsletter):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $newsletter['Newsletter']['subject']; ?>
                        </td>
                        <td>
                            <?php echo !empty($newsletter['Newsletter']['sent']) ? __('Yes', true) : __('No', true); ?>
                        </td>
                        <td>
                            <?php if (!empty($newsletter['Newsletter']['sent'])) : ?>
                                <?php echo $time->nice($newsletter['Newsletter']['modified']); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $time->nice($newsletter['Newsletter']['created']); ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('View', true), array('action' => 'view', $newsletter['Newsletter']['id'])); ?>
                            <?php if (empty($newsletter['Newsletter']['sent'])) : ?>
                                / <?php echo $html->link(__('Send to All', true), array('action' => 'send', $newsletter['Newsletter']['id']), null, sprintf(__('Are you sure you want to send the newsletter with the subject to all users: %s?', true), $newsletter['Newsletter']['subject'])); ?>
                                / <?php echo $html->link(__('Send to Purchased Only', true), array('action' => 'send', $newsletter['Newsletter']['id'], true), null, sprintf(__('Are you sure you want to send the newsletter with the subject to users who have purchased bids: %s?', true), $newsletter['Newsletter']['subject'])); ?>
                                / <?php echo $html->link(__('Send Test', true), array('action' => 'test', $newsletter['Newsletter']['id']), null, sprintf(__('Are you about to send a test to: %s?', true), $appConfigurations['email'])); ?>
                                / <?php echo $html->link(__('Edit', true), array('action' => 'edit', $newsletter['Newsletter']['id'])); ?>
                            <?php endif; ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $newsletter['Newsletter']['id']), null, sprintf(__('Are you sure you want to delete the newsletter with the subject: %s?', true), $newsletter['Newsletter']['subject'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>
    <?php else: ?>
        <p><?php __('There are no newsletters at the moment.'); ?></p>
    <?php endif; ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $html->link(__('New Newsletter', true), array('action' => 'add')); ?></li>
    </ul>
</div>