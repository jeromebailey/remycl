<header class="header header-sticky mb-4">
    <div class="container-fluid">
      <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
        <svg class="icon icon-lg">
          <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-men')}}'"></use>
        </svg>
      </button><a class="header-brand d-md-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
          <use xlink:href="{{asset('img/brand/coreui.svg#full')}}"></use>
        </svg></a>
      <ul class="header-nav d-none d-md-flex">
        
      </ul>
      <ul class="header-nav ms-auto">
        
      </ul>
      <ul class="header-nav ms-3">
        <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <div class="avatar avatar-md" style="border:0">
            @if (empty(Auth::user()->profile_picture))
                @php
                    $initials = strtoupper(substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1));
                @endphp
                <span class="initials avatar-img" style="background-color: {{ session('emptyProfileImageBGColour'); }}">{{ $initials }}</span>
            @else
                <img src="{{ asset('img/avatars/8.jpg') }}" class="avatar-img" alt="{{ Auth::user()->email }}">
            @endif
        </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end pt-0">
            <div class="dropdown-header bg-light py-2">
              <div class="fw-semibold">Settings</div>
            </div><a class="dropdown-item" href="#">
              <svg class="icon me-2">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
              </svg> My Profile</a>
            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('logout')}}">
              <svg class="icon me-2">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout')}}"></use>
              </svg> Logout</a>
          </div>
        </li>
      </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
          <li class="breadcrumb-item">
            <!-- if breadcrumb is single--><span>Home</span>
          </li>
          
          @if( !empty($breadcrumbs) )
            @foreach($breadcrumbs as $key => $item)
            
              @if ($key === array_key_last($breadcrumbs)) 
                <li class="breadcrumb-item active"><span>{{$item['crumb']}}</span></li>
              @else
                <li class="breadcrumb-item"><span><a href="{{route($item['path'])}}">{{$item['crumb']}}</a></span></li>
              @endif
            @endforeach
          @endif
          
          
        </ol>
      </nav>
    </div>
  </header>