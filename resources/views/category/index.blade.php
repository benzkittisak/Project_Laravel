@extends('layouts.master')
@section('title') BikeShop | ข้อมูลประเภทสินค้า @stop


@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <strong>รายการ</strong>
            </div>
        </div>
        <div class="panel-body">
            <form action="/category/search" method="post" class="form-inline">
                <a href="{{URL::to('category/edit')}}" class="btn btn-success pull-right">เพิ่มประเภทสินค้า</a>
            </form>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อประเภทสินค้า</th>
                    <th>การทำงาน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $item)
                    <tr>
                        <td>{{ $item->id}}</td>
                        <td>{{ $item->name}}</td>
                        <td align="center">
                            <a href="{{URL::to('category/edit/'.$item->id)}}" class="btn btn-info">แก้ไข</a>
                            <a href="#" class="btn btn-danger btn-delete" id-delete="{{$item->id}}">ลบ</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="panel-footer">
           <span>แสดงข้อมูลจำนวน {{count($categories)}} รายการ</span> 
           {{-- {{$products->links('pagination::bootstrap-4')}} --}}
        </div>
    </div>
</div>

<script>
   $('.btn-delete').on('click',function() {
            if(confirm('คุณต้องการลบข้อมูลประเภทสินค้าหรือไม่?')){
                var url = "{{URL::to('category/remove')}}" + '/' + $(this).attr('id-delete');
                window.location.href=url;           
                }
        });
</script>
@endsection