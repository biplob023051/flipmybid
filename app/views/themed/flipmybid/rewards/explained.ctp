<div class="col-md-3 col-sm-12 col-xs-12 g7">
    <?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
    <div id="auctions" class="rounded">
        <div id="tabs">
            <h2><?php __('Membership Levels Explained'); ?></h2>
        </div>
        <div class="account">
            <div class="">
                <p>Your Membership Level: <?php print(ucfirst(strtolower($membership['Membership']['name']))); ?></p>

                <p>Your Accumulated Bid Points: <?php print($bidPoints); ?></p>
                <table class="table table-condensed table-striped" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="headings">
                        <td>Level</td>
                        <td>Perk 1</td>
                        <td>Perk 2</td>
                        <td>Perk 3</td>
                    </tr>
                    <tr>
                        <td>Silver</td>
                        <td>Yes</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Gold</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Platinum</td>
                        <td>Yes</td>
                        <td>Yes</td>
                        <td>Yes</td>
                    </tr>
                </table>
                <?php
                $nextLevelPoints = intval($nextMembership['Membership']['points']);
                $pointsRequired = $nextLevelPoints - $bidPoints;
                ?>
                <p>The next Membership Level you can reach
                    is <?php print(ucfirst(strtolower($nextMembership['Membership']['name']))); ?>. To reach this level
                    you need to place <?php print($pointsRequired); ?> more bids.</p>
            </div>
        </div>
    </div>
    <!--/ Auctions -->
</div>