@extends('layouts.master')

@section('title')
    Bikeshop | ชำระเงิน
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>ชำระเงิน</h1>

                <ul class="breadcrumb">
                    <li>
                        <a href="{{url('/home')}}">
                            <i class="fa fa-home"></i> หน้าร้าน
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/cart/view')}}">
                            สินค้าในตะกร้า
                        </a>
                    </li>
                    <li class="active">
                            ชำระเงิน
                    </li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {{-- ข้อมูลสินค้าในตะกร้า --}}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>รายการสินค้า</strong>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="active">
                                <th></th>
                                <th>รหัส</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวน</th>
                                <th class="text-right">ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum_price = 0 ; $sum_qty = 0 ;?>
                            @foreach ($cart_items as $item)
                                <tr>
                                    <td>
                                        <img src="{{asset($item['image_url'])}}" width="50px">
                                    </td>
                                    <td>
                                        {{$item['code']}}
                                    </td>
                                    <td>
                                        {{$item['name']}}
                                    </td>
                                    <td>
                                        {{number_format($item['qty'] , 0)}}
                                    </td>
                                    <td align="right">
                                        {{number_format($item['price'] * $item['qty'] , 0)}}
                                    </td>
                                </tr>
                                <?php
                                    $sum_price += $item['price'] * $item['qty'];
                                    $sum_qty += $item['qty'];
                                ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">รวม</th>
                                <th>{{number_format($sum_qty , 0)}}</th>
                                <th class="text-right">{{number_format($sum_price , 0)}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>
            <div class="col-md-6">
                {{-- ข้อมูลผู้ซื้อสินค้า --}}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>ข้อมูลลูกค้า</strong>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="cust_name">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" id="cust_name" placeholder="ชื่อ-นามสกุล">
                        </div>
                        <div class="form-group">
                            <label for="cust_email">อีเมล</label>
                            <input type="text" class="form-control" id="cust_email" placeholder="อีเมลของท่าน">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <a href="{{url('/cart/view')}}" class="btn btn-default">ย้อนกลับ</a>

                <div class="pull-right">
                    <a href="{{url('/cart/complete')}}" class="btn btn-warning">พิมพ์ใบสั่งซื้อ</a>
                    <a href="javascript:complete()" class="btn btn-primary"><i class="fa fa-check"></i> จบการขาย</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function complete() {
            window.open("{{url('/cart/complete')}}?cust_name=" + $('#cust_name').val() + 
            "&cust_email=" + $('#cust_email').val() , "_blank");
        }
    </script>
@endsection