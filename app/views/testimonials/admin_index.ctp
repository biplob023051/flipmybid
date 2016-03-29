<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="auctions index">

    <h2>Testimonials</h2>

    <?php if ($this->requestAction('/settings/get/testimonial_testing_mode') && $this->requestAction('/settings/enabled/testing_mode')) : ?>
        <div class="actions">
            <ul>
                <li><?php echo $html->link(__('Add a testimonial (Testing Mode)', true), array('action' => 'add')); ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($testimonials)): ?>

        <?php echo $this->element('admin/pagination'); ?>

        <div id="orderMessage" class="message" style="display: none"></div>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('name'); ?></th>
                    <th><?php echo $paginator->sort('location'); ?></th>
                    <th><?php echo $paginator->sort('username'); ?></th>
                    <th><?php echo $paginator->sort('Auction Title', 'Product.title'); ?></th>
                    <th><?php echo $paginator->sort('approved'); ?></th>
                    <th><?php echo $paginator->sort('created'); ?></th>
                    <th class="actions"><?php __('Options'); ?></th>
                </tr>
                <tbody id="testimonialList">
                <?php
                $i = 0;
                foreach ($testimonials as $testimonial):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?> id="testimonial_<?php echo $testimonial['Testimonial']['id']; ?>">
                        <td>
                            <?php echo $testimonial['Testimonial']['name']; ?>
                        </td>
                        <td>
                            <?php echo $testimonial['Testimonial']['location']; ?>
                        </td>
                        <td>
                            <?php echo $html->link($testimonial['User']['username'], array('controller' => 'users', 'action' => 'view', $testimonial['User']['id'])); ?>
                        </td>
                        <td>
                            <?php if (!empty($testimonial['Auction']['Product']['title'])) : ?>
                                <?php echo $html->link($testimonial['Auction']['Product']['title'], array('admin' => false, 'controller' => 'auctions', 'action' => 'view', $testimonial['Auction']['id']), array('target' => '_blank')); ?>
                            <?php else : ?>
                                n/a
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($testimonial['Testimonial']['approved'])) : ?>
                                Yes
                            <?php else : ?>
                                No
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $time->nice($testimonial['Testimonial']['created']); ?>
                        </td>
                        <td class="actions">
                            <?php echo $html->link(__('Edit', true), array('action' => 'edit', $testimonial['Testimonial']['id'])); ?>
                            / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $testimonial['Testimonial']['id']), null, sprintf(__('Are you sure you want to delete testimonial by: %s?', true), $testimonial['Testimonial']['name'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

        <?php if ($this->requestAction('/settings/get/testimonial_testing_mode') && $this->requestAction('/settings/enabled/testing_mode')) : ?>
            <div class="actions">
                <ul>
                    <li><?php echo $html->link(__('Add a testimonial (Testing Mode)', true), array('action' => 'add')); ?></li>
                </ul>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p><?php __('There are no testimonials at the moment.'); ?></p>
    <?php endif; ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#testimonialList').sortable({
            'items': 'tr',
            update: function () {
                $.ajax({
                    url: '/admin/testimonials/saveorder/',
                    type: 'POST',
                    data: $(this).sortable('serialize'),
                    success: function (data) {
                        $('#orderMessage').html(data).show('fast').animate({opacity: 1.0}, 2000).fadeOut('slow');
                    }
                });
            }
        });
    });
</script>