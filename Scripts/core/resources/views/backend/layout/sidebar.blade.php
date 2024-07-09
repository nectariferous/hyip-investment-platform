<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.home') }}">{{ @$general->sitename }}</a>
        </div>

        <ul class="sidebar-menu">

            <li class="nav-item dropdown {{ menuActive('admin.home') }}">
                <a href="{{ route('admin.home') }}" class="nav-link ">
                    <i data-feather="home"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>

            <li class="sidebar-menu-caption">{{ __('Administration') }}</li>

            @if (auth()->guard('admin')->user()->can('manage-role'))

                <li class="nav-item dropdown {{ menuActive('admin.roles.index') }}">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link ">
                        <i data-feather="users"></i>
                        <span>{{ __('Manage Role') }}</span>
                    </a>
                </li>

            @endif

            @if (auth()->guard('admin')->user()->can('manage-admin'))
                <li class="nav-item dropdown {{ menuActive('admin.admins.index') }}">
                    <a href="{{ route('admin.admins.index') }}" class="nav-link ">
                        <i data-feather="user-check"></i>
                        <span>{{ __('Manage Admins') }}</span>
                    </a>
                </li>
            @endif


            <li class="sidebar-menu-caption">{{ __('Manage Plan') }}</li>

            @if (auth()->guard('admin')->user()->can('manage-plan'))
                <li class="nav-item dropdown {{ menuActive('admin.plan*') }}">
                    <a href="{{ route('admin.plan.index') }}" class="nav-link ">
                        <i data-feather="box"></i>
                        <span>{{ __('Manage Plan') }}</span>
                    </a>
                </li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-schedule'))
                <li class="nav-item dropdown {{ menuActive('admin.time*') }}">
                    <a href="{{ route('admin.time.index') }}" class="nav-link ">
                        <i data-feather="calendar"></i>
                        <span>{{ __('Schedule') }}</span>
                    </a>
                </li>
            @endif


            <li class="sidebar-menu-caption">{{ __('User Management') }}</li>

            @if (auth()->guard('admin')->user()->can('manage-user'))
                <li class="nav-item dropdown {{ @$navManageUserActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="user"></i>
                        <span>{{ __('Manage Users') }} @if (@$deactiveUser > 0)
                                <i
                                    class="far fa-bell text-danger animate__animated animate__infinite animate__heartBeat animate__slow"></i>
                            @endif
                        </span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavManageUserActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.user') }}">{{ __('Manage Users') }}</a>
                        </li>

                        <li class="{{ @$subNavActiveUserActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.user.filter', 'active') }}">{{ __('Active Users') }}</a>
                        </li>

                        <li class="{{ @$subNavDeactiveUserActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.user.filter', 'deactive') }}">{{ __('Deactive Users') }} <span
                                    class="badge badge-danger">{{ @$deactiveUser }}</span></a>
                        </li>


                        <li class="{{ @$subNavkycUserActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.user.kyc') }}">{{ __('KYC Setting') }}</a>
                        </li>


                        <li class="{{ @$subNavkycReqUserActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.user.kyc.req') }}">{{ __('KYC Request') }}</a>
                        </li>


                    </ul>
                </li>
            @endif




            @if (auth()->guard('admin')->user()->can('manage-ticket'))
                <li class="nav-item dropdown {{ @$navTicketActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="inbox"></i>
                        <span>{{ __('Ticket') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$ticketList }}">
                            <a class="nav-link" href="{{ route('admin.ticket.index') }}">{{ __('All Tickets') }}</a>
                        </li>
                        <li class="{{ @$pendingTicket }}">
                            <a class="nav-link"
                                href="{{ route('admin.ticket.pendingList') }}">{{ __('Pending Ticket') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-referral'))
                <li class="nav-item dropdown {{ menuActive('admin.referral*') }}">
                    <a href="{{ route('admin.referral.index') }}" class="nav-link ">
                        <i data-feather="link"></i>
                        <span>{{ __('Manage Referral') }}</span>
                    </a>
                </li>
            @endif




            <li class="sidebar-menu-caption">{{ __('Payment and Payout') }}</li>

            @if (auth()->guard('admin')->user()->can('Manual-payments'))
                <li class="nav-item dropdown {{ @$navManualPaymentActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="database"></i>
                        <span>{{ __('Manual Payments') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavManualPaymentActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.manual') }}">{{ __('Manual Payments') }}</a>
                        </li>

                        <li class="{{ @$subNavPendingPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.manual.status', 'pending') }}">{{ __('Pending Payments') }}</a>
                        </li>

                        <li class="{{ @$subNavAcceptedPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.manual.status', 'accepted') }}">{{ __('Accepted Payments') }}</a>
                        </li>

                        <li class="{{ @$subNavRejectedPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.manual.status', 'rejected') }}">{{ __('Rejected Payments') }}</a>
                        </li>

                    </ul>
                </li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-withdraw'))
                <li class="nav-item dropdown {{ @$navManageWithdrawActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="package"></i>
                        <span>{{ __('Manage Withdraw') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavWithdrawMethodActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.withdraw') }}">{{ __('Withdraw Method') }}</a>
                        </li>
                        <li class="{{ @$subNavWithdrawPendingActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.withdraw.pending') }}">{{ __('Pending Withdraws') }}</a>
                        </li>
                        <li class="{{ @$subNavWithdrawAcceptedActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.withdraw.accepted') }}">{{ __('Accepted Withdraws') }}</a>
                        </li>
                        <li class="{{ @$subNavWithdrawRejectedActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.withdraw.rejected') }}">{{ __('Rejected Withdraws') }}</a>
                        </li>
                    </ul>
                </li>
            @endif


            @if (auth()->guard('admin')->user()->can('manage-deposit'))
                <li class="nav-item dropdown {{ menuActive('admin.deposit.log') }}">
                    <a href="{{ route('admin.deposit.log') }}" class="nav-link ">
                        <i data-feather="table"></i>
                        <span>{{ __('Manage Deposit') }}</span>
                    </a>
                </li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-email') ||
                auth()->guard('admin')->user()->can('manage-setting') ||
                auth()->guard('admin')->user()->can('manage-gateway') ||
                auth()->guard('admin')->user()->can('manage-language'))
                <li class="sidebar-menu-caption">{{ __('System Settings') }}</li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-gateway'))
                <li class="nav-item dropdown {{ @$navPaymentGatewayActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="credit-card"></i>
                        <span>{{ __('Gateway Settings') }}</span></a>
                    <ul class="dropdown-menu">

                        <li class="{{ @$subNavPaypalPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.gateway.index') }}">{{ __('Create Gateway') }}</a>
                        </li>


                        <li class="{{ @$subNavPaypalPaymentActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.payment.paypal') }}">{{ __('Paypal') }}</a>
                        </li>
                        <li class="{{ @$subNavStripePaymentActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.payment.stripe') }}">{{ __('Stripe') }}</a>
                        </li>
                        <li class="{{ @$subNavCoinpaymentsPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.coin') }}">{{ __('Coinpayments') }}</a>
                        </li>

                        <li class="{{ @$subNavRazorpayPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.razorpay') }}">{{ __('Razorpay') }}</a>
                        </li>

                        <li class="{{ @$subNavVougePayPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.vougepay') }}">{{ __('VougePay') }}</a>
                        </li>

                        <li class="{{ @$subNavMolliePaymentActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.payment.mollie') }}">{{ __('Mollie') }}</a>
                        </li>

                        <li class="{{ @$subNavNowPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.nowpay') }}">{{ __('NowPayments') }}</a>
                        </li>

                        <li class="{{ @$subNavFlutterPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.fullerwave') }}">{{ __('Flutterwave') }}</a>
                        </li>

                        <li class="{{ @$subNavPayStackPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.paystack') }}">{{ __('PayStack') }}</a>
                        </li>


                        <li class="{{ @$subNavPayStackPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.paghiper') }}">{{ __('PagHiper') }}</a>
                        </li>


                        <li class="{{ @$subNavgourlPaymentActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.payment.gourl') }}">{{ __('Gourl.io') }}</a>
                        </li>

                        <li class="{{ @$subNavperfectPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.perfectmoney') }}">{{ __('Perfect Money') }}</a>
                        </li>


                        <li class="{{ @$subNavperfectPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.mercadopago') }}">{{ __('MercadoPago') }}</a>
                        </li>


                        <li class="{{ @$subNavpaytmPaymentActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.payment.paytm') }}">{{ __('Paytm') }}</a>
                        </li>


                        <li class="{{ @$subNavBankPaymentActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.payment.bank') }}">{{ __('Bank Payment') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-email'))
                <li class="menu-header">{{ __('Email Settings') }}</li>

                <li class="nav-item dropdown {{ @$navEmailManagerActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="mail"></i>
                        <span>{{ __('Email Manager') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavEmailConfigActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.email.config') }}">{{ __('Email Configure') }}</a>
                        </li>
                        <li class="{{ @$subNavEmailTemplatesActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.email.templates') }}">{{ __('Email Templates') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

          


            @if (auth()->guard('admin')->user()->can('manage-setting'))

                <li class="menu-header">{{ __('System Settings') }}</li>

                <li class="nav-item dropdown {{ @$navGeneralSettingsActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="settings"></i>
                        <span>{{ __('General Settings') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavGeneralSettingsActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.setting') }}">{{ __('General Settings') }}</a>
                        </li>
                        <li class="{{ @$subNavPreloaderActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.preloader') }}">{{ __('Preloader Setting') }}</a>
                        </li>
                        <li class="{{ @$subNavAnalyticsActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.analytics') }}">{{ __('Google Analytics') }}</a>
                        </li>
                        <li class="{{ @$subNavCookieActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.cookie') }}">{{ __('Cookie Consent') }}</a>
                        </li>
                        <li class="{{ @$subNavRecaptchaActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.recaptcha') }}">{{ __('Google Recaptcha') }}</a>
                        </li>
                        <li class="{{ @$subNavLiveChatActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.live.chat') }}">{{ __('Live Chat Setting') }}</a>
                        </li>
                        <li class="{{ @$subNavSEOManagerActiveClass }}">
                            <a class="nav-link"
                                href="{{ route('admin.general.seo') }}">{{ __('Global SEO Manager') }}</a>
                        </li>

                        <li>
                            <a class="nav-link"
                                href="{{ route('admin.general.cacheclear') }}">{{ __('Cache Clear') }}</a>
                        </li>
                    </ul>
                </li>
            @endif


            @if (auth()->guard('admin')->user()->can('manage-language'))
                <li class="nav-item dropdown {{ @$navManageLanguageActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="globe"></i>
                        <span>{{ __('Manage Language') }}</span></a>
                    <ul class="dropdown-menu">

                        <li class="{{ @$subNavManageLanguageActiveClass }}"><a class="nav-link"
                                href="{{ route('admin.language.index') }}">{{ __('Manage Language') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (auth()->guard('admin')->user()->can('manage-theme'))
                

            <li class="nav-item dropdown {{ menuActive('admin.manage.theme*') }}">
                <a href="{{ route('admin.manage.theme') }}" class="nav-link ">
                    <i data-feather="layers"></i>
                    <span>{{ __('Manage Theme') }}</span>
                </a>
            </li>
        @endif

            @if (auth()->guard('admin')->user()->can('manage-logs'))
                <li class="sidebar-menu-caption">{{ __('Logs') }}</li>

                <li class="nav-item dropdown {{ menuActive('admin.user.interestlog') }}">
                    <a href="{{ route('admin.user.interestlog') }}" class="nav-link ">
                        <i data-feather="percent"></i>
                        <span>{{ __('User Interest Log') }}</span>
                    </a>
                </li>

                <li class="nav-item dropdown {{ menuActive('admin.commision') }}">
                    <a href="{{ route('admin.commision') }}" class="nav-link ">
                        <i data-feather="file-text"></i>
                        <span>{{ __('Commission Log') }}</span>
                    </a>
                </li>
            @endif




            @if (auth()->guard('admin')->user()->can('manage-frontend') ||
                auth()->guard('admin')->user()->can('manage-subscriber'))

                <li class="sidebar-menu-caption">{{ __('Others') }}</li>

            @endif
            @if (auth()->guard('admin')->user()->can('manage-frontend'))

                <li class="nav-item dropdown {{ @$navManagePagesActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="layout"></i>
                        <span>{{ __('Frontend') }}</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavPagesActiveClass }}">
                            <a class="nav-link" href="{{ route('admin.frontend.pages') }}">{{ __('Pages') }}</a>
                        </li>

                        @forelse($urlSections as $key => $section)
                            <li class="">
                                <a class="nav-link"
                                    href="{{ route('admin.frontend.section.manage', ['name' => $key]) }}">{{ frontendFormatter($key) . ' Section' }}</a>
                            </li>
                        @empty

                        @endif
                    </ul>

                </li>

            @endif

            @if (auth()->guard('admin')->user()->can('manage-subscriber'))
                <li class="nav-item dropdown {{ menuActive('admin.subscribers') }}">
                    <a href="{{ route('admin.subscribers') }}" class="nav-link ">
                        <i data-feather="at-sign"></i>
                        <span>{{ __('Newsletter Subscriber') }}</span>
                    </a>
                </li>
            @endif



            @if (auth()->guard('admin')->user()->can('manage-report'))
                <li class="menu-header">{{ __('Reports') }}</li>

                <li class="nav-item mb-3 dropdown {{ @$navReportActiveClass }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="alert-octagon"></i>
                        <span>{{ __('Report') }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ @$subNavPaymentReportActiveClass }}"><a class="nav-link"
                                href="{{ route('admin.payment.report') }}">{{ __('Payment Reports') }}</a>
                        </li>
                        <li class="{{ @$subNavWithdrawReportActiveClass }}"><a class="nav-link"
                                href="{{ route('admin.withdraw.report') }}">{{ __('Withdraw Reports') }}</a>
                        </li>

                        <li class="{{ @$subNavTransactionActiveClass }}">
                            <a href="{{ route('admin.transaction') }}"
                                class="nav-link ">{{ __('Manage Transaction') }}</a>
                        </li>
                    </ul>
                </li>
            @endif


            <li class="nav-item dropdown {{ menuActive('admin.update.system') }}">
                <a href="{{ route('admin.update.system') }}" class="nav-link ">
                    <i data-feather="home"></i>
                    <span>{{ __('Update System') }}</span>
                </a>
            </li>
            
            
            <li class="sidebar-menu-caption">{{ __('Current Version') }} {{ $general->current_version }}</li>

        </ul>
    </aside>
</div>
