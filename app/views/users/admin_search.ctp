<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Users'); ?></h2>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Create a new user', true), array('action' => 'add')); ?></li>
        <li><?php echo $html->link(__('Show all user', true), array('action' => 'index')); ?></li>
    </ul>
</div>
<div class="searchBox">
    <?php echo $form->create('User', array('action' => 'search')); ?>
    <fieldset>
        <?php echo $form->input('name', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-4'))); ?>
        <?php echo $form->input('email', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-4'))); ?>
        <?php echo $form->input('username', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-4'))); ?>
    </fieldset>
    <?php echo $form->end('Search'); ?>
</div>
<?php if (!empty($users)): ?>

    <?php echo $this->element('admin/pagination'); ?>
    <div class="table-responsive">
        <table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $paginator->sort('username'); ?></th>
                <th><?php echo $paginator->sort('first_name'); ?></th>
                <th><?php echo $paginator->sort('last_name'); ?></th>
                <th><?php echo $paginator->sort('email'); ?></th>
                <?php if ($this->requestAction('/settings/enabled/memberships')) : ?>
                    <th><?php echo $paginator->sort(__('Membership', true), 'Membership.name'); ?></th>
                <?php endif; ?>
                <th><?php echo $paginator->sort('ip'); ?></th>
                <?php if ($this->requestAction('/settings/enabled/newsletter')) : ?>
                    <th><?php echo $paginator->sort('newsletter'); ?></th>
                <?php endif; ?>
                <?php if ($this->requestAction('/settings/enabled/registration_sources')) : ?>
                    <th><?php echo $paginator->sort('Source', 'source.name'); ?></th>
                <?php endif; ?>
                <th><?php echo $paginator->sort(__('Verified', true), 'active'); ?></th>
                <th><?php echo $paginator->sort('created'); ?></th>
                <th class="actions"><?php __('Options'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($users as $user):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                $delete = 1;
                ?>
                <tr<?php echo $class; ?>>
                    <td><?php echo $user['User']['username']; ?></td>
                    <td><?php echo $user['User']['first_name']; ?></td>
                    <td><?php echo $user['User']['last_name']; ?></td>
                    <td><a href="mailto:<?php echo $user['User']['email']; ?>"><?php echo $user['User']['email']; ?></a>
                    </td>
                    <?php if ($this->requestAction('/settings/enabled/memberships')) : ?>
                        <td><?php if (!empty($user['Membership']['name'])) : ?><?php echo $user['Membership']['name']; ?><?php else : ?><?php __('n/a'); ?><?php endif; ?></td>
                    <?php endif; ?>

                    <td>
                        <?php if (!empty($user['User']['ip'])): ?>
                            <?php //$location = $this->requestAction('/users/ip/'.$user['User']['ip']); ?>
                            <?php $location = '';
                            if (empty($location)) : ?>
                                <?php $location = $user['User']['ip']; ?>
                            <?php endif; ?>
                            <?php echo $html->link($location, 'http://centralops.net/co/DomainDossier.aspx?addr=' . $user['User']['ip'] . '&dom_whois=true&net_whois=true', array('target' => '_blank')); ?>
                        <?php else: ?>
                            <?php __('Not Available'); ?>
                        <?php endif; ?>
                    </td>
                    <?php if ($this->requestAction('/settings/enabled/newsletter')) : ?>
                        <td><?php if ($user['User']['newsletter'] == 1) : ?><?php __('Yes'); ?><?php else: ?><?php __('No'); ?><?php endif; ?></td>
                    <?php endif; ?>

                    <?php if ($this->requestAction('/settings/get/registration_options')) : ?>
                        <td>
                            <?php if (!empty($user['Source']['name'])): ?>
                                <?php echo $user['Source']['name']; ?>
                                <?php if (!empty($user['User']['source_extra'])): ?>
                                    (<?php echo $user['User']['source_extra']; ?>)
                                <?php endif; ?>
                            <?php elseif (!empty($user['User']['source_extra'])): ?>
                                <?php echo $text->autoLink($user['User']['source_extra'], array('target' => '_blank')); ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                    <td><?php if ($user['User']['active'] == 1) : ?><?php __('Yes'); ?><?php elseif (!empty($user['User']['deleted'])) : ?><?php __('Deleted'); ?><?php else: ?><?php __('No'); ?><?php endif; ?></td>
                    <td><?php echo $time->niceShort($user['User']['created']); ?></td>
                    <td class="actions">
                        <?php if (empty($user['User']['active'])): ?>
                            <?php echo $html->link(__('Resend Activation Email', true), array('action' => 'resend', $user['User']['id'])); ?> /
                        <?php endif; ?>
                        <?php echo $html->link(__('View', true), array('action' => 'view', $user['User']['id'])); ?>
                        / <?php echo $html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?>
                        / <?php echo $html->link(__('Admin Rights', true), array('action' => 'rights', $user['User']['id'])); ?>
                        / <?php echo $html->link(__('Bids', true), array('controller' => 'bids', 'action' => 'user', $user['User']['id'])); ?>
                        <?php if ($this->requestAction('/settings/enabled/bid_butler')) : ?>
                            / <?php echo $html->link(__('Bid Buddies', true), array('controller' => 'bidbutlers', 'action' => 'user', $user['User']['id'])); ?>
                        <?php endif; ?>
                        / <?php echo $html->link(__('Won Auctions', true), array('controller' => 'auctions', 'action' => 'user', $user['User']['id'])); ?>
                        <?php if ($this->requestAction('/settings/enabled/reward_points')) : ?>
                            / <?php echo $html->link(__('Reward Points', true), array('controller' => 'points', 'action' => 'user', $user['User']['id'])); ?>
                        <?php endif; ?>
                        <?php if ($this->requestAction('/settings/enabled/win_limits')) : ?>
                            / <?php echo $html->link(__('Win Limits', true), array('controller' => 'limits', 'action' => 'user', $user['User']['id'])); ?>
                        <?php endif; ?>
                        <?php if ($this->requestAction('/settings/enabled/referrals')) : ?>
                            / <?php echo $html->link(__('Referred Users', true), array('controller' => 'referrals', 'action' => 'user', $user['User']['id'])); ?>
                        <?php endif; ?>

                        <?php if (empty($user['User']['admin'])) : ?>
                            <?php if (!empty($user['User']['active'])): ?>
                                / <?php echo $html->link(__('Suspend', true), array('action' => 'suspend', $user['User']['id']), null, sprintf(__('Are you sure you want to suspend the user: %s?', true), $user['User']['username'])); ?> /
                                / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete the user: %s?  Users should only be deleted if they have requested their account to be deleted or as a last minute resort, as it can have consequences on other areas of the website.  We recommend using the suspend option instead.', true), $user['User']['username'])); ?>
                            <?php else : ?>
                                / <?php echo $html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete the user: %s?', true), $user['User']['username'])); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php echo $this->element('admin/pagination'); ?>

<?php else: ?>
    <p><?php __('There are no users at the moment.'); ?></p>
<?php endif; ?>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Create a new user', true), array('action' => 'add')); ?></li>
    </ul>
</div>
