@extends('admin.layout')
@section('content')
     <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
               用户管理
                <small>列表</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 后台</a></li>
                <li><a href="#">用户管理</a></li>
                <li class="active">列表</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">用户基本信息表</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        @if(session('info'))
                        <div id ='showhidden' class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>    <i class="icon fa fa-check"></i> 提示!</h4>
                            {{session('info')}}

                           @endif
                         </div>
                         <script type="text/javascript">
                            
                            window.onload = function(){

                                $('#showhidden').hide(2000);
                            }
                
                         </script>
                           
                             <div class = "row">
                               <form action ="{{url('admin/user/index')}}" method="get">
                         

                                    <div class = 'col-md-4'>
                                        
                                        <select  name ="num" class="form-control">
                                            <option value="10"
                                                @if(!empty($request['num']) && $request['num'] == 10)
                                                    selected ='selectd'

                                                @endif >
                                                10

                                            </option>
                                            <option value="20"
                                                    @if(!empty($request['num']) &&
                                                    $request['num'] == 20)
                                                    selected ='selectd'

                                                @endif >

                                            20</option>
                                            <option value="50"
                                                @if(!empty($request['num']) && $request['num']==50)
                                                    selected = 'selected'
                                                @endif

                                            >50</option>
                                            <option value="100"

                                            @if(!empty($request['num']) && $request['num']==100)
                                                    selected = 'selected'
                                                @endif


                                            >100</option>
                                        </select>



                                    </div>




                                    <div class = 'col-md-6 col-md-offset-2'>
                                        
                                        <div class="input-group input-group">
                                            <input class="form-control" name="keyword" type="text">
                                            <span class="input-group-btn">
                                              <button class="btn btn-info btn-flat">搜索</button>
                                            </span>
                                         </div>

                                   </div>
                              </form>



                           </div>
                          
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>邮　箱</th>
                                    <th>手机号</th>
                                    <th>操　作</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $user )
                                <tr>
                                    <td class = 'ids'>{{$user -> user_id}}</td>
                                    <td name = 'username'>{{$user -> username}} </td>
                                    <td>{{$user -> email}}</td>
                                    <td>{{$user -> phone}}</td>
                
                                    <td>
                                    <a href="{{url('/admin/user/edit')}}/{{$user->user_id}}">编辑</a>|
                                        
                                     <a href="{{url('/admin/user/delete')}}/{{$user->user_id}}">删除</a>|

                                     <a href ="{{url('/admin/user/details')}}/{{$user -> user_id}}">查看用户详情</a>
                                    <a href="{{ url('/admin/topic/topicAdd') }}/{{ $user -> user_id }}">发表话题</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                               
                            </table>    
                        
                         {!! $data->render() !!}
    
        
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <script type="text/javascript">
        
        window.onload =function()
        {

            // alert($);
            //使用ajax 用Post提交要先设置头信息在layout里面设置
                  
            $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
             });

            //添加事件
            $('.lang').on('click',function(){

                  // alert(111);
                  var lang =$(this);
                  var id = $(this).parent().find('.ids').html();
                    // alert(111);
                  $.post('/admin/user/ajaxUpdate',{id:id},function(data){
                        // alert(data);
                        if(data =='0')
                        {
                           lang.html('禁用');
                        }else if(data==2)

                        {
                            lang.html('启用');

                        }else if(data =='3')
                        {
                            lang.html('启用');
                        }else{

                            lang.html('禁用');
                        }





                  },'json');

                  

            });

            //双击修改用户
            $('td[name = username]').on('dblclick',function(){
                var td =$(this);
                var id = td.prev().html();
                var username = td.html();
                var inp =$('<input type = "text"/>');
                inp.val(username);
                //将表单放入到td中.
                td.html(inp);
                //双击鼠标选中input里面的值


                inp.select();
                //失去焦点事件
                inp.blur(function(){
                    //获取新修改的值
                    var newname = inp.val();

                     if(username == newname)
                         {
                            alert('无效的操作');
                             td.html(username);
                            return;
                         }

                    //发送ajax
                    $.post('/admin/user/ajaxUsername',{id:id,username:newname},function(data){

                         if(data =='1')
                         {
                            alert('用户名已存在');
                            td.html(username);
                         }
                         else if(data =='0')
                         {
                           
                            td.html(newname);

                         }else{

                            alert('用户名修改失败');
                            td.html(username);

                         }


                    },'json');




                });





            });
        }



    </script>




@endsection
