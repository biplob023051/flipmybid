
<div class="col-md-9 col-sm-12 col-md-push-3">
    <div id="auctions" class="rounded">
        <?php echo $this->element('user_submenu', array('active' => 'Live')); ?>
        <?php if (!empty($future)) : ?>
            <div class="col-sm-12" style="margin-top:20px;">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   style="text-decoration: none;font-size:20px;" id="hider"
                                   href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Upcoming Auctions
                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true" style="float:right;"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne"
                              class="panel-collapse collapse <?php if ($session->check('Upcoming.collapse') && $session->read('Upcoming.collapse') == '1'): ?>in<?php endif; ?>"
                             role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <?php echo $this->element('auction_carousel_only', array('auctions' => $future)); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>
        <?php endif; ?>

        <?php if (!empty($auctions)) : ?>
            <?php echo $this->element('paginate'); ?>
            <?php echo $this->element('auction_carousel', array('auctions' => $auctions)); ?>
            <?php echo $this->element('paginate'); ?>
            <div class="clearfix" style="padding-bottom:10px;">&nbsp;</div>
        <?php else : ?>
            <div class="c-content">
                <h2>Check Again Soon</h2>

                <p><?php __('There are no live auctions at the moment.'); ?></p>

            </div>
        <?php endif; ?>
        <!--/ Listing -->
    </div>
    <!--/ Auctions -->
</div>
<div class="col-sm-12 col-md-3 col-md-pull-9">
    <?php if (!$session->check('Auth.User')): ?>
        <?php echo $this->element('register'); ?>
    <?php else: ?>
        <?php echo $this->element('tab'); ?>
    <?php endif; ?>
</div>
<script>
    $('#hider').on('click', function(e){
        //ajax to set session
        $.ajax({
            url: '/auctions/upcoming_session_set',
            type: 'POST',
            success: function (data) {
                //console.log(data);
            }
        });
    });
</script>