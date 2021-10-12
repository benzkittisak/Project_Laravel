<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title" , "BikeShop | จำหน่ายอะไหล่จักรยานออนไลน์")</title>
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src={{ asset('vendor/toastr/toastr.min.js') }}></script>
</head>
<body>

    @if (!Session::get('cart_items'))
        <?php Session::put('cart_items', [])?>
    @endif

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand">BikeShop</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="{{URL::to('home')}}">หน้าแรก</a></li>
                            @guest
                            @else
                            <li><a href="{{URL::to('product')}}">ข้อมูลสินค้า</a></li>
                            <li><a href="{{URL::to('category')}}">ข้อมูลประเภทสินค้า</a></li>
                            <li><a href="#">รายงาน</a></li>
                            @endguest  
                        </ul>


                        <ul class="nav navbar-nav navbar-right">
                            @guest
                            <li>
                                <a href="{{route('login')}}">เข้าสู่ระบบ</a>
                            </li>
                            <li>
                                <a href="{{route('register')}}">สมัครสมาชิก</a>
                            </li>
                            @else
                            <li>
                                <a href="#">{{ Auth::user()->name }}</a>
                            </li>
                            <li>
                                
                                <a href="{{url('logout')}}">ออกจากระบบ</a>
                            </li>
                            @endguest

                            <li>
                                <a href="{{URL::to('cart/view')}}">
                                    <i class="fa fa-shopping-cart"></i> ตะกร้า


                                    @if (count([Session::get('cart_items')]))
                                        <span class="label label-danger">
                                            {!! count(Session::get('cart_items')) !!}
                                        </span>
                                    @endif
                                </a>
                            </li>
                           
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @yield("content")
   
    {{-- js --}}
    @if (session('msg'))
        @if (session('ok'))
            <script>toastr.success("{{session('msg')}}")</script>   
        @else
            <script>toastr.error("{{session('msg')}}")</script>
        @endif
    @endif

    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>