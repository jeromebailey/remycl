@extends('layouts.app')
@section('content')

<link href="/css/background.css" rel="stylesheet"/>
<link href="/css/font.css" rel="stylesheet"/>
<link href="/css/card.css" rel="stylesheet"/>

<div id="app-content" class="my-2 p-0">
    <div class="bg-img-100" style="background-image: url('/img/welcome8.jpg');">
        <div class="row">
            <div class="col-md-3 col-lg-3 m-4">
                <div class="card-welcome card-body-sm bg-light-blue">
                    <div class="row p-3 my-auto mx-3">
                        <div class="flex-column flex-fill text-left">
                            <span class="text-xl-600-navy-blue"  style="color: white; font-size: 1.66rem">{{ __('Need Help?') }}</span> 
                        </div>
                    </div>
                    <div class="row p-3 my-2 mx-3">
                        <div class="flex-column flex-fill text-left" >
                            <span class="text-sm-500-light-blue" style="bottom: 100%; color: white">
                                <a class="font-navy" href="{{ route('apply') }}" style="color: white">Click here to apply now</a>
                                <i class="fa fa-arrow-alt-circle-right ml-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://feedback.happy-or-not.com/v1/bootloader/C5B929C6D9119FD77C89ADA1490C8D96/bootloaderjs/?lang=en-US&init=true"></script>
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}" ></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>

@endsection