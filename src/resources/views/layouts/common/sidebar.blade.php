<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;

$role = Auth::user()->roles;
$slug = $role[0]->slug;
$slugToUse = ($slug === 'super-admin') ? 'admin' : $slug;

$dashboardRoute = User::determineDashboardFromRole($slug);
?>

<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
      <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
        <use xlink:href="{{asset('img/brand/coreui.svg#full')}}"></use>
      </svg>
      <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
        <use xlink:href="{{asset('img/brand/coreui.svg#signet')}}"></use>
      </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
      <li class="nav-item"><a class="nav-link" href="{{route($dashboardRoute)}}">
          <svg class="nav-icon">
            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer')}}"></use>
          </svg> My Dashboard</a></li>
      
      @can('see-clients-menu')
      <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
          <svg class="nav-icon">
            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-healing')}}"></use>
          </svg> Clients</a>
        <ul class="nav-group-items">
        @can('import-clients')
            <li class="nav-item"><a class="nav-link" href="{{route($slugToUse.'/import-clients')}}"><span class="nav-icon"></span> Import Clients</a></li>
          @endcan
          @can('view-all-clients')
            @if( $slug === 'sales-exec' )
              <li class="nav-item"><a class="nav-link" href="{{route('sales-exec/clients')}}"><span class="nav-icon"></span> My Clients</a></li>
            @elseif( $slug === 'super-admin' )
              <li class="nav-item"><a class="nav-link" href="{{route($slugToUse.'/clients')}}"><span class="nav-icon"></span> All Clients</a></li>
            @endif
          @endcan
        </ul>
      </li>
      @endcan

      {{-- @can('see-clients-menu')
      <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
          <svg class="nav-icon">
            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-healing')}}"></use>
          </svg> Payments</a>
        <ul class="nav-group-items">
          @can('view-all-clients')
            @if( $slug === 'sales-exec' )
              <li class="nav-item"><a class="nav-link" href="{{route('sales-exec/clients')}}"><span class="nav-icon"></span> My Clients</a></li>
            @elseif( $slug === 'super-admin' )
              <li class="nav-item"><a class="nav-link" href="{{route($slugToUse.'/clients')}}"><span class="nav-icon"></span> All Clients</a></li>
            @endif
          @endcan
        </ul>
      </li>
      @endcan --}}

      @if( (auth()->user()->roles[0]->slug === 'super-admin' || auth()->user()->roles[0]->slug === 'sales-exec') && auth()->user()->can('view-reports'))
      <li class="nav-item"><a class="nav-link" href="{{route($slugToUse.'/reports')}}">
          <svg class="nav-icon">
            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-bell-exclamation')}}"></use>
          </svg> Reports</a>
      </li>
      @endif

      @if($slug === 'super-admin')
      <li class="nav-divider"></li>
      <li class="nav-title">Admin</li>
      <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
          <svg class="nav-icon">
            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle')}}"></use>
          </svg> Admin Roles</a>
        <ul class="nav-group-items">

        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle')}}"></use>
            </svg> Permissions</a>
            <ul class="nav-group-items">
              <li class="nav-item"><a class="nav-link" href="{{route('admin/permissions')}}"><span class="nav-icon"></span> All Permissions</a></li>
              <li class="nav-item"><a class="nav-link" href="base/breadcrumb.html"><span class="nav-icon"></span> Add Permission</a></li>
              <li class="nav-item"><a class="nav-link" href="base/cards.html"><span class="nav-icon"></span> Assign Permission to Role</a></li>
            </ul>
          </li>

          <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle')}}"></use>
            </svg> Roles</a>
            <ul class="nav-group-items">
              <li class="nav-item"><a class="nav-link" href="nothing.html"><span class="nav-icon"></span> All Roles</a></li>
              <li class="nav-item"><a class="nav-link" href="base/breadcrumb.html"><span class="nav-icon"></span> Add Role</a></li>
              <li class="nav-item"><a class="nav-link" href="base/cards.html"><span class="nav-icon"></span> Device Inventory</a></li>
            </ul>
          </li>

          @can('see-users-menu')
          <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle')}}"></use>
            </svg> Users</a>
            <ul class="nav-group-items">
              @can('view-all-health-e-users')
              <li class="nav-item"><a class="nav-link" href="{{route('admin/users')}}"><span class="nav-icon"></span> All Users</a></li>
              @endcan

              @can('add-user')
              <li class="nav-item"><a class="nav-link" href="{{route('admin/add-user')}}"><span class="nav-icon"></span> Add User</a></li>
              @endcan
            </ul>
          </li>
          @endcan
        </ul>
      </li>
      @endif
      
      
      
      <li class="nav-item mt-auto"><a class="nav-link" href="https://coreui.io/docs/templates/installation/" target="_blank">
          <svg class="nav-icon">
            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-description')}}"></use>
          </svg> App Settings</a></li>
      
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
  </div>

  @include('patients.onboarding.patient-holder')

  @section('scripts')
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@stop