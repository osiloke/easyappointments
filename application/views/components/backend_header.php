<li?php /** * Local variables. * * @var string $active_menu * @var string $company_logo */ ?>
    <div class="navbar bg-black text-white z-50" data-theme="lofi">
        <div>
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow  rounded-box w-52 bg-black">
                    <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                    <li class=" <?= $active . $hidden ?>">
                        <a href="<?= site_url('calendar' . (vars('calendar_view') === CALENDAR_VIEW_TABLE ? '?view=table' : '')) ?>" class="nav-link" data-tippy-content="<?= lang('manage_appointment_record_hint') ?>">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <?= lang('calendar') ?>
                        </a>
                    </li>

                    <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_CUSTOMERS ? 'active' : ''; ?>
                    <li class="nav-item <?= $active . $hidden ?>">
                        <a href="<?= site_url('customers') ?>" class="nav-link" data-tippy-content="<?= lang('manage_customers_hint') ?>">
                            <i class="fas fa-user-friends me-2"></i>
                            <?= lang('customers') ?>
                        </a>
                    </li>

                    <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_CUSTOMERS ? 'active' : ''; ?>
                    <li class="nav-item <?= $active . $hidden ?>">
                        <a href="<?= site_url('packages') ?>" class="nav-link" data-tippy-content="View all<?= lang('listings') ?>">
                            <i class="fas fa-plus me-2"></i>
                            <?= lang('Listings') ?>
                        </a>
                    </li>
                    <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_CUSTOMERS ? 'active' : ''; ?>
                    <li class="nav-item <?= $active . $hidden ?>">
                        <a href="<?= site_url('packages/new') ?>" class="nav-link" data-tippy-content="New <?= lang('listing') ?>">
                            <i class="fas fa-plus me-2"></i>
                            New <?= lang('listing') ?>
                        </a>
                    </li>
                    <?php $hidden = can('view', PRIV_SERVICES) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_SERVICES ? 'active' : ''; ?>
                    <li class="nav-item dropdown <?= $active . $hidden ?>">
                        <details>
                            <summary data-tippy-content="<?= lang(
                                                                'manage_services_hint',
                                                            ) ?>"><i class="fas fa-business-time me-2"></i>
                                <?= lang('services') ?></summary>
                            <ul class="p-2 text-white">
                                <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                                <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                                <li class="<?= $active . $hidden ?>">
                                    <a class="dropdown-item" href="<?= site_url('services') ?>">
                                        <?= lang('services') ?>
                                    </a>
                                    <a class="dropdown-item" href="<?= site_url('categories') ?>">
                                        <?= lang('categories') ?>
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>

                    <?php $hidden = can('view', PRIV_USERS) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_USERS ? 'active' : ''; ?>
                    <li class="nav-item dropdown <?= $active . $hidden ?>">
                        <details>
                            <summary data-tippy-content="<?= lang('manage_users_hint') ?>">
                                <i class="fas fa-users me-2"></i>
                                <?= lang('users') ?>
                            </summary>
                            <ul class="p-2 text-white">
                                <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                                <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                                <li class="<?= $active . $hidden ?>">
                                    <a class="dropdown-item" href="<?= site_url('providers') ?>">
                                        <?= lang('providers') ?>
                                    </a>
                                    <a class="dropdown-item" href="<?= site_url('secretaries') ?>">
                                        <?= lang('secretaries') ?>
                                    </a>
                                    <a class="dropdown-item" href="<?= site_url('admins') ?>">
                                        <?= lang('admins') ?>
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                    <?php $hidden = can('view', PRIV_SYSTEM_SETTINGS) || can('view', PRIV_USER_SETTINGS) ? '' : 'd-none'; ?>
                    <?php $active = $active_menu == PRIV_SYSTEM_SETTINGS ? 'active' : ''; ?>

                    <li class="hover:text-white nav-item dropdown dropdown-end <?= $active . $hidden ?>">
                        <details>
                            <summary data-tippy-content="<?= lang('settings_hint') ?>">
                                <i class="fas fa-user me-2"></i>
                                <?= e(vars('user_display_name')) ?>
                            </summary>
                            <ul class="p-2 text-white">
                                <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                                <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                                <li class="<?= $active . $hidden ?>">
                                    <?php if (can('view', PRIV_SYSTEM_SETTINGS)) : ?>
                                        <a class="dropdown-item" href="<?= site_url('general_settings') ?>">
                                            <?= lang('settings') ?>
                                        </a>
                                    <?php endif; ?>
                                    <a class="dropdown-item" href="<?= site_url('account') ?>">
                                        <?= lang('account') ?>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                        <?= lang('log_out') ?>
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>
            <a class="btn btn-ghost normal-case text-xl" href="/">
                <img src=" <?= base_url('assets/img/logo-white.svg') ?>" alt="logo">
                <h6>
                    <?= vars('company_name') ?>
                </h6>
            </a>
        </div>
        <div class="hidden lg:flex lg:visible ">
            <ul class="menu menu-horizontal px-1 text-base-100">
                <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                <li class=" <?= $active . $hidden ?>">
                    <a href="<?= site_url('calendar' . (vars('calendar_view') === CALENDAR_VIEW_TABLE ? '?view=table' : '')) ?>" class="nav-link" data-tippy-content="<?= lang('manage_appointment_record_hint') ?>">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <?= lang('calendar') ?>
                    </a>
                </li>

                <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_CUSTOMERS ? 'active' : ''; ?>
                <li class="nav-item <?= $active . $hidden ?>">
                    <a href="<?= site_url('customers') ?>" class="nav-link" data-tippy-content="<?= lang('manage_customers_hint') ?>">
                        <i class="fas fa-user-friends me-2"></i>
                        <?= lang('customers') ?>
                    </a>
                </li>

                <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_CUSTOMERS ? 'active' : ''; ?>
                <li class="nav-item <?= $active . $hidden ?>">
                    <a href="<?= site_url('packages') ?>" class="nav-link" data-tippy-content="View all<?= lang('listings') ?>">
                        <?= lang('Listings') ?>
                    </a>
                </li>
                <?php $hidden = can('view', PRIV_SERVICES) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_SERVICES ? 'active' : ''; ?>
                <li class="nav-item dropdown <?= $active . $hidden ?>">
                    <details>
                        <summary data-tippy-content="<?= lang(
                                                            'manage_services_hint',
                                                        ) ?>"><i class="fas fa-business-time me-2"></i>
                            <?= lang('services') ?></summary>
                        <ul class="p-2 text-black">
                            <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                            <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                            <li class="<?= $active . $hidden ?>">
                                <a class="dropdown-item" href="<?= site_url('services') ?>">
                                    <?= lang('services') ?>
                                </a>
                                <a class="dropdown-item" href="<?= site_url('categories') ?>">
                                    <?= lang('categories') ?>
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

                <?php $hidden = can('view', PRIV_USERS) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_USERS ? 'active' : ''; ?>

                <li class="nav-item dropdown <?= $active . $hidden ?>">
                    <details>
                        <summary data-tippy-content="<?= lang('manage_users_hint') ?>">
                            <i class="fas fa-users me-2"></i>
                            <?= lang('users') ?>
                        </summary>
                        <ul class="p-2 text-black">
                            <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                            <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                            <li class="<?= $active . $hidden ?>">
                                <a class="dropdown-item" href="<?= site_url('providers') ?>">
                                    <?= lang('providers') ?>
                                </a>
                                <a class="dropdown-item" href="<?= site_url('secretaries') ?>">
                                    <?= lang('secretaries') ?>
                                </a>
                                <a class="dropdown-item" href="<?= site_url('admins') ?>">
                                    <?= lang('admins') ?>
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
                <?php $hidden = can('view', PRIV_CUSTOMERS) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_CUSTOMERS ? 'active' : ''; ?>
                <!-- <li class="nav-item <?= $active . $hidden ?>">
                    <a href="<?= site_url('packages/new') ?>" class="nav-link" data-tippy-content="New <?= lang('listing') ?>">
                        <i class="fas fa-plus me-2"></i>
                        New <?= lang('listing') ?>
                    </a>
                </li> -->
                <?php $hidden = can('view', PRIV_SYSTEM_SETTINGS) || can('view', PRIV_USER_SETTINGS) ? '' : 'd-none'; ?>
                <?php $active = $active_menu == PRIV_SYSTEM_SETTINGS ? 'active' : ''; ?>

                <li class="hover:text-white nav-item dropdown dropdown-end <?= $active . $hidden ?>">
                    <details>
                        <summary data-tippy-content="<?= lang('settings_hint') ?>">
                            <i class="fas fa-user me-2"></i>
                            <?= e(vars('user_display_name')) ?>
                        </summary>
                        <ul class="p-2 text-black">
                            <?php $hidden = can('view', PRIV_APPOINTMENTS) ? '' : 'd-none'; ?>
                            <?php $active = $active_menu == PRIV_APPOINTMENTS ? 'active' : ''; ?>
                            <li class="<?= $active . $hidden ?>">
                                <?php if (can('view', PRIV_SYSTEM_SETTINGS)) : ?>
                                    <a class="dropdown-item" href="<?= site_url('general_settings') ?>">
                                        <?= lang('settings') ?>
                                    </a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?= site_url('account') ?>">
                                    <?= lang('account') ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                    <?= lang('log_out') ?>
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>

    <div id="notification" style="display: none;"></div>

    <div id="loading" style="display: none;">
        <div class="any-element animation is-loading">
            &nbsp;
        </div>
    </div>