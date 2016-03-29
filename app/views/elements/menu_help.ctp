<?php $sections = $this->requestAction('/sections/getsections'); ?>

<?php if(!empty($sections)) : ?>
	<div class="module">
		<?php foreach ($sections as $section) : ?>
			<h4 class="heading">
			<?php if(!empty($question_id)) : ?>
				<?php echo $html->link($section['Section']['name'], array('action' => 'index', $section['Section']['id'], Inflector::slug($section['Section']['name'], '-'), $question['Question']['id'], Inflector::slug($question['Question']['question'], '-')));?>
			<?php else : ?>
				<?php echo $html->link($section['Section']['name'], array('action' => 'index', $section['Section']['id'], Inflector::slug($section['Section']['name'], '-')));?>
			<?php endif; ?>
			</h4>
			<?php if(empty($id)) : ?>
				<?php $id = $section['Section']['id']; ?>
			<?php endif; ?>

			<?php if($id == $section['Section']['id']) : ?>
				<?php $questions = $this->requestAction('/questions/getquestions/'.$section['Section']['id']); ?>
				<?php if(!empty($questions)) : ?>
					<ul class="questions">
						<?php foreach ($questions as $question) : ?>
							<li><?php echo $html->link($question['Question']['question'], array('action' => 'index', $section['Section']['id'], Inflector::slug($section['Section']['name'], '-'), $question['Question']['id'], Inflector::slug($question['Question']['question'], '-')));?></li>
						<?php endforeach; ?>
					</ul>
					<hr noshade size="1" color="#cf3a33">
				<?php else : ?>
					<p><?php __('There are no questions in this section.'); ?></p>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<p><?php __('There are no help sections at the moment.'); ?></p>
<?php endif; ?>