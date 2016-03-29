<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);

echo $this->element('admin/crumb');
?>

<div class="categories index">

    <h2><?php __('Banners'); ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Add a new banner', true), array('action' => 'add')); ?></li>
        </ul>
    </div>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('description'); ?></th>
                    <th><?php echo $paginator->sort('banner_location_id'); ?></th>
                    <th><?php echo $paginator->sort('order'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($banners as $banner):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td><?php echo $banner['Banner']['description']; ?></td>
                        <td><?php echo $banner['BannerLocation']['name']; ?></td>
                        <td><?php echo $banner['Banner']['order']; ?></td>
                        <td class="actions">
                            <?php echo $html->link(__('Edit', true), array('action' => 'edit', $banner['Banner']['id'])); ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $banner['Banner']['id']), null, __('Are you sure you want to delete this banner?', true)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
    <p><?php __('There are no banners at the moment.'); ?>
        <?php endif; ?>
</div>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Add a new banner', true), array('action' => 'add')); ?></li>
    </ul>
</div>
