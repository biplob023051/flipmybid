<div class="col-md-3 col-sm-12 col-xs-12 g7">
    <?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
    <div id="auctions" class="rounded">
        <div id="tabs">
            <h2><?php __('My Addresses'); ?></h2>
        </div>
        <div class="account">
            <?php if (!empty($address)) : ?>
                <?php foreach ($address as $name => $address) : ?>
                    <h2><?php echo $name; ?> <?php __('Address'); ?></h2>
                    <?php if (!empty($address['Address']['id'])) : ?>
                        <div class="table-responsive visible-lg visible-md">
                            <table class="table default-table table-condensed table-striped" width="100%" border="0" cellspacing="0"
                                   cellpadding="0">
                                <tr class="headings">
                                    <td><?php __('Name'); ?></td>
                                    <td><?php __('Address'); ?></td>
                                    <td><?php __('Town'); ?></td>
                                    <td><?php __('County'); ?></td>
                                    <td><?php __('Postcode'); ?></td>
                                    <td><?php __('Country'); ?></td>
                                    <td><?php __('Phone Number'); ?></td>
                                    <td class="actions"><?php __('Options'); ?></td>
                                </tr>

                                <tr>
                                    <td><?php echo $address['Address']['name']; ?></td>
                                    <td><?php echo $address['Address']['address_1']; ?><?php if (!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?></td>
                                    <td><?php if (!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
                                    <td><?php echo $address['Address']['city']; ?></td>
                                    <td><?php echo $address['Address']['postcode']; ?></td>
                                    <td><?php echo $address['Country']['name']; ?></td>
                                    <td><?php if (!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
                                    <td>
                                        <a href="/addresses/edit/<?php echo $address['Address']['user_address_type_id']; ?>"><?php __('Edit'); ?></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive visible-sm visible-xs">
                            <table class="table table-condensed table-striped" width="100%" border="0" cellspacing="0"
                                   cellpadding="0" style="font-size: 14px;">
                                <tr class="headings">
                                    <td><?php __('Name'); ?></td>
                                    <td>&nbsp;<?php echo $address['Address']['name']; ?></td>
                                </tr><tr>
                                    <td><?php __('Address'); ?></td>
                                    <td>&nbsp;<?php echo $address['Address']['address_1']; ?><?php if (!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?>
                                    <?php if (!empty($address['Address']['suburb'])) : ?><br/>&nbsp;<?php echo $address['Address']['suburb']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
                                </tr><tr>
                                    <td><?php __('Town'); ?></td>
                                    <td>&nbsp;<?php echo $address['Address']['city']; ?></td>
                                </tr><tr>
                                    <td><?php __('County'); ?></td>
                                    <td>&nbsp;<?php echo $address['Country']['name']; ?></td>
                                </tr><tr>
                                    <td><?php __('Postcode'); ?></td>
                                    <td>&nbsp;<?php echo $address['Address']['postcode']; ?></td>
                                </tr><tr>
                                    <td><?php __('Phone Number'); ?></td>
                                    <td>&nbsp;<?php if (!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
                                </tr><tr>
                                    <td class="actions"><?php __('Options'); ?></td>
                                    <td>
                                        <a href="/addresses/edit/<?php echo $address['Address']['user_address_type_id']; ?>">&nbsp;<?php __('Edit'); ?></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>
                            <a href="/addresses/add/<?php echo $address['Address']['user_address_type_id']; ?>"><?php echo sprintf(__('Add a %s address', true), $name); ?></a>
                        </p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!--/ Auctions -->
</div>
