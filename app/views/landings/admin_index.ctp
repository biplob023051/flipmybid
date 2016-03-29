<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(__('Landing Pages', true), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="landings index">

    <h2><?php __('Landing Pages'); ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Add a new landing page', true), array('action' => 'add')); ?></li>
        </ul>
    </div>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('title'); ?></th>
                    <th><?php echo $paginator->sort('description'); ?></th>
                    <th><?php echo $paginator->sort('product_id'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($landings as $landing):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $landing['Landing']['title']; ?>
                        </td>
                        <td>
                            <?php echo $landing['Landing']['description']; ?>
                        </td>
                        <td>
                            <?php if (!empty($landing['Product'])) : ?>
                                <?php echo $landing['Product']['title']; ?>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('View', true), '/landing/' . $landing['Landing']['slug'], array('target' => '_blank')); ?>
                            / <?php echo $html->link(__('Edit', true), array('action' => 'edit', $landing['Landing']['id'])); ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $landing['Landing']['id']), null, sprintf(__('Are you sure you want to delete the landing page named: %s?', true), $landing['Landing']['title'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('There are no landing pages at the moment.'); ?></p>
    <?php endif; ?>
</div>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Add a new landing page', true), array('action' => 'add')); ?></li>
    </ul>
</div>