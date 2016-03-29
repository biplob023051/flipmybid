<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(__('Sections', true), '/admin/sections');
$html->addCrumb($section['Section']['name'], '/admin/' . $this->params['controller'] . '/view/' . $section['Section']['id']);
echo $this->element('admin/crumb');
?>

<div class="questions index">

    <h2>Questions for: <?php echo $section['Section']['name']; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $html->link('Add a new question for this section', array('action' => 'add', $section['Section']['id'])); ?></li>
        </ul>
    </div>

    <?php if ($paginator->counter() > 0): ?>
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
            <p><?php __('To change the order that the questions are displayed, drag and drop the ordering by clicking and draging on the table below.'); ?></p>
        </div>
        <div id="orderMessage" class="message" style="display: none"></div>

        <?php echo $this->element('admin/pagination'); ?>
        <div class="table-responsive">
            <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $paginator->sort('question'); ?></th>
                    <th class="actions">Options</th>
                </tr>
                <tbody id="questionList">
                <?php
                $i = 0;
                foreach ($questions as $question):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    ?>
                    <tr<?php echo $class; ?> id="question_<?php echo $question['Question']['id']; ?>">
                        <td>
                            <?php echo $question['Question']['question']; ?>
                        </td>
                        <td class="actions">
                            <?php if ($this->requestAction('/settings/enabled/multi_languages')) : ?>
                                <?php echo $html->link(__('Edit', true), array('action' => 'translations', $question['Question']['id'])); ?>
                            <?php else : ?>
                                <?php echo $html->link(__('Edit', true), array('action' => 'edit', $question['Question']['id'])); ?>
                            <?php endif; ?>
                            / <?php echo $html->link('Delete', array('action' => 'delete', $question['Question']['id']), null, sprintf(__('Are you sure you want to delete this question: %s?', true), $question['Question']['question'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('admin/pagination'); ?>

    <?php else: ?>
        <p>There are no questions in this section.</p>
    <?php endif; ?>
</div>

<div class="actions">
    <ul>
        <li><?php echo $html->link('Add a new question for this section', array('action' => 'add', $section['Section']['id'])); ?></li>
    </ul>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#questionList').sortable({
            'items': 'tr',
            update: function () {
                $.ajax({
                    url: '/admin/questions/saveorder',
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