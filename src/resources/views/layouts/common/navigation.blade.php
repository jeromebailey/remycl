<div class="container mx-0" id="top-nav-container">
    <nav class="navbar navbar-light navbar-expand fixed-top navigation-clean-button ml-0 py-0" id="navbar-top">
        <div class="container-fluid"><a class="navbar-brand" href="/"></a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"><i class="fas fa-user-circle" id="dropdown-navbar-profile-icon" style="font-size: 30px;color: rgb(28,54,93);"></i></span></button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                </ul><img src="{{ asset('img/govky-logo.svg') }}" height="40" style="padding: 0px 10px;height: 30px;">
                {{-- <div class="dropdown"><a aria-expanded="false" data-toggle="dropdown" href="{{ route('/')}}"><i class="fas fa-user-circle" id="navbar-profile-icon" title="Profile Menu"></i></a>
                    <div class="dropdown-menu" id="navbar-dropdown-profile-menu"><a class="dropdown-item dropdown-profile-item" href="#"><i class="fas fa-sign-in-alt dropdown-profile-item mr-2"></i>Sign in</a><a class="dropdown-item dropdown-profile-item" href="#"><i class="fas fa-clipboard-check dropdown-profile-icon mr-2"></i>Register</a></div>
                </div><span class="navbar-text actions"> </span> --}}
            </div>
        </div>
    </nav>
</div>
<div class="container" id="top-nav-logo" style="height: 80px;margin-top: 100px;left: 0px;">
    <nav class="navbar navbar-light navbar-expand-md" id="navbar-logo" style="padding: 0px 0px; "> <!-- width: 100vw; -->
        <div class="container-fluid"><a class="navbar-brand" href="{{ route('/')}}"><img src="{{asset('img/NAU_Horizontal.png')}}" height="" style="padding: 0px 0px;"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-4"><a class="nav-link active" href="https://nau.gov.ky">HOME</a></li>
                    <li class="nav-item mx-4"><a class="nav-link" href="{{ route('apply')}}">APPLY</a></li>
                    <li class="nav-item mx-4"><a class="nav-link" href="{{route('find-incomplete-application')}}" title="Retrieve application">RETRIEVE</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/js/bs-init.js"></script>
<script src="/js/sidebar.js"></script>