<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="news index">

<h2>Sections</h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link('Add a new section', array('action' => 'add')); ?></li>
	</ul>
</div>

<?php if(!empty($sections)):?>

<p><?php __('To change the order that the sections are displayed, drag and drop the ordering by clicking and draging on the table below.');?></p>

<div id="orderMessage" class="message" style="display: none"></div>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions">Options</th>
</tr>
<tbody id="sectionList">
<?php
$i = 0;
foreach ($sections as $section):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?> id="section_<?php echo $section['Section']['id'];?>">
		<td>
			<?php echo $section['Section']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link('Questions', array('controller' => 'questions', 'action' => 'view', $section['Section']['id'])); ?>
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				/ <?php echo $html->link(__('Edit', true), array('action'=>'translations', $section['Section']['id'])); ?>
			<?php else : ?>
				/ <?php echo $html->link(__('Edit', true), array('action'=>'edit', $section['Section']['id'])); ?>
			<?php endif; ?>
			/ <?php echo $html->link('Delete', array('action' => 'delete', $section['Section']['id']), null, sprintf(__('Are you sure you want to delete the section titled: %s?', true), $section['Section']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p>There are no sections at the moment</p>
<?php endif;?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link('Add a new section', array('action' => 'add')); ?></li>
	</ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#sectionList').sortable({
        'items': 'tr',
        update: function(){
            $.ajax({
                url: '/admin/sections/saveorder',
                type: 'POST',
                data: $(this).sortable('serialize'),
                success: function(data){
                    $('#orderMessage').html(data).show('fast').animate({opacity: 1.0}, 2000).fadeOut('slow');
                }
            });
        }
    });
});
</script>