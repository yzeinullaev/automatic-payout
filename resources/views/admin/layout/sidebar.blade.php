<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/branches') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.branch.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/agents') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.agent.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/partners') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.partner.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/pay-statuses') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.pay-status.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/pay-types') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.pay-type.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/contract-lists') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.contract-list.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
