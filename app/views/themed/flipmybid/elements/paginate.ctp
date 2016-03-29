<!-- Start Results Bar -->
<?php if ($this->Paginator && $this->Paginator->counter(array('format' => '%pages%')) > 1): ?>
    <div class="clearfix"></div>
    <div class="paginateAuction col-sm-12" >
        <div class="col-xs-4 prev" style="text-align: left;">
            <?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
        </div>
        <!-- Shows the page numbers -->
        <div class="col-xs-4 numbers">
            <?php echo $this->Paginator->numbers(); ?>
        </div>
        <!-- Shows the next and previous links -->

        <div class="col-xs-4 next" style="text-align: right;">
            <?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>
        </div>
        <!-- prints X of Y, where X is current page and Y is number of pages -->
    </div>
    <div class="clearfix"></div>
<?php endif; ?>


<!-- End Results Bar -->