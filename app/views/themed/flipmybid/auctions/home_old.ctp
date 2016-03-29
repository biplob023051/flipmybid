<div class="col-md-9 col-sm-12 col-md-push-3">
    <div id="auctions" class="rounded">
        <?php echo $this->element('user_submenu', array('active' => 'Home')); ?>

        <?php if (!empty($auctions_end_soon)) : ?>
            <?php echo $this->element('paginate'); ?>
            <?php echo $this->element('auction_carousel', array('auctions' => $auctions_end_soon)); ?>
            <?php echo $this->element('paginate'); ?>
        <?php else : ?>
            <div class="c-content">
                <h2>Check Again Soon</h2>

                <p>There are currently no live auctions. Please check again soon.</p>


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