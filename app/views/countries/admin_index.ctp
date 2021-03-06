<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="countries index">

    <h2><?php __('Countries'); ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $html->link(__('Add a new Country', true), array('action' => 'add')); ?></li>
        </ul>
    </div>

    <?php if ($paginator->counter() > 0): ?>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('name'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($countries as $country):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo $country['Country']['name']; ?>
                        </td>
                        <td class="actions">
                            <?php if ($this->requestAction('/settings/enabled/multi_languages')) : ?>
                                <?php echo $html->link(__('Edit', true), array('action' => 'translations', $country['Country']['id'])); ?>
                            <?php else : ?>
                                <?php echo $html->link(__('Edit', true), array('action' => 'edit', $country['Country']['id'])); ?>
                            <?php endif; ?>
                            <?php if (empty($country['UserAddress'])) : ?>
                                / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $country['Country']['id']), null, sprintf(__('Are you sure you want to delete the country named: %s?', true), $country['Country']['name'])); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p><?php __('There are no countries at the moment.'); ?></p>
    <?php endif; ?>
</div>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Add a new Country', true), array('action' => 'add')); ?></li>
    </ul>
</div>
