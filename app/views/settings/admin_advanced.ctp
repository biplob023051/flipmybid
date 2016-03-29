<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Modules', true), '/admin/modules');
if (!empty($module['Module']['name'])) {
    $html->addCrumb(Inflector::humanize($module['Module']['name']), '/admin/settings/module/' . $module['Module']['id']);
}
$html->addCrumb(Inflector::humanize($module['Setting']['name']), '/admin/settings/advanced/' . $module['Setting']['id']);
echo $this->element('admin/crumb');
?>

<div class="settings module">

    <h2><?php __('Advanced Settings for:'); ?><?php echo Inflector::humanize($module['Setting']['name']); ?></h2>

    <?php if (!empty($settings)) : ?>
        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('name'); ?></th>
                    <th><?php echo $paginator->sort('description'); ?></th>
                    <th><?php echo $paginator->sort('value'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <?php
                $i = 0;
                foreach ($settings as $setting):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?>>
                        <td>
                            <?php echo Inflector::humanize($setting['Setting']['name']); ?>
                        </td>
                        <td>
                            <?php echo $setting['Setting']['description']; ?>
                        </td>
                        <td>
                            <?php if (!empty($setting['Setting']['options'])) {
                                if ($setting['Setting']['value'] == '1') {
                                    __('Yes');
                                } elseif ($setting['Setting']['value'] == '0') {
                                    __('No');
                                } else {
                                    echo $setting['Setting']['value'];
                                }
                            } else {
                                echo $setting['Setting']['value'];
                            } ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('Edit', true), array('action' => 'edit', $setting['Setting']['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>
    <?php else : ?>
        <p><?php __('There are no advanced settings available.'); ?></p>
    <?php endif; ?>
</div>

<div class="actions">
    <ul>
        <?php if (!empty($module['Module']['id'])) : ?>
            <li><?php echo $html->link(__('<< Back to module settings', true), array('action' => 'module', $module['Module']['id'])); ?></li>
        <?php else : ?>
            <li><?php echo $html->link(__('<< Back to settings', true), array('action' => 'index')); ?></li>
        <?php endif; ?>
    </ul>
</div>