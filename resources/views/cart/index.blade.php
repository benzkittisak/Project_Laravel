@extends('layouts.master') @section('title')
    BikeShop | ตะกร้าสินค้า @stop
    @section('content')
        <div class="container">
            <h1>สินค้าในตะกร้า</h1>
            <ul class="breadcrumb">
                <li><a href="{{URL::to('home')}}"><i class="fa fa-home"></i>หน้าแรก</a></li>
                <li class="active">สินค้าในตะกร้า</li>
            </ul>
            <div class="panel panel-default">
                @if (count($cart_items))
                    <?php $sum_price = 0 ;?>
                    <?php $sum_qty = 0 ;?>
                

                <table class="table">
                    <thead>
                        <tr class="active">
                            <th>รูปสินค้า</th>
                            <th>รหัส</th>
                            <th>ชื่อสินค้า</th>
                            <th width="100px">จำนวน</th>
                            <th>ราคา</th>
                            <th width="50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart_items as $item)
                            <tr>
                                <td>
                                    <img src="{{asset($item['image_url'])}}" alt="" width="50px">
                                </td>
                                <td>
                                    {{$item['code']}}
                                </td>
                                <td>
                                    {{$item['name']}}
                                </td>
                                <td>
                                    <input 
                                    type="text" 
                                    class="form-control" 
                                    value="{{$item['qty']}}" 
                                    onKeyUp = "updateCart({{$item['id']}},this)">
                                </td>
                                <td>
                                    {{number_format($item['price'] * $item['qty'], 0)}}
                                </td>
                                <td>
                                    <a href="{{URL::to('cart/delete/'.$item['id'])}}" class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $sum_price += $item['price']?>
                            <?php $sum_qty += $item['qty']?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">รวม</th>
                            <th>{{number_format($sum_qty , 0)}}</th>
                            <th>{{number_format($sum_price * $item['qty'] , 0)}}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                @else
                    <div class="panel-body">
                        <strong>ไม่พบรายการสินค้า!</strong>
                    </div>
                @endif
            </div>

            {{-- Buttons --}}
            <a href="{{URL::to('/home')}}" class="btn btn-default">ย้อนกลับ</a>
            <div class="pull-right">
                <a href="{{URL::to('cart/checkout')}}" class="btn btn-primary">
                    ชำระเงิน <i class="fa fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function updateCart(id,qty) {
        if(qty.value){
            window.location.href = '/cart/update/' + id + '/' + qty.value;
        }
    }
</script>
@endsection