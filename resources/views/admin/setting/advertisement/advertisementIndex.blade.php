@extends('../layouts.admin')
@section('title','Category Index')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-14">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Category List</h3>


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Type</th>
                                <th>Advertisement Host</th>
                                <th>Advertisement Code</th>
                                <th>Advertisement Image</th>
                                <th>Full Link</th>
                                <th>At Page</th>
                                <th>At Position</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            if($listData){
                                $labeClass = "label-success";
                                $labeName = "Active";
                                foreach ($listData as $list){

                                    $delete_url = url()->current().'?page='.$page.'&delete=true&id='.$list['id'];
                                    $edit_url = url()->current().'?page='.$page.'&isEdit=true&id='.$list['id'];;

                                    if($list['active'] == 0){
                                        $class = "danger";
                                        $active_url =url()->current().'?page='.$page.'&active=1&id='.$list['id'];
                                        $status_button = '<a href='.$active_url.'  class=" col-sm-4 btn btn-sm btn-success btn-flat pull-left">Active</a>';
                                    }else{
                                        $class = "";
                                        $active_url =url()->current().'?page='.$page.'&active=0&id='.$list['id'];
                                        $status_button = '<a href='.$active_url.'  class=" col-sm-4 btn btn-sm btn-warning btn-flat pull-left">Deactive</a>';
                                    }
                                    echo '<tr class="'.$class.'">';
                                    echo $list['type'] == 1? "<td class = 'col-md-1'>News</td>" : "<td class = 'col-md-1'>Social NetWork</td>";
                                    $labeClass = $list['active']?"label-success" : "label-danger";
                                    $labeName = $list['active']?"Active" : "Block";


                                    //echo '<td><span class="label '.$labeClass.'">'.$labeName.'</span></td>';
                                    echo '<td><span >'.$list["ads_host"].'</span></td>';
                                    echo '<td><span >'.$list["ads_code"].'</span></td>';
                                    echo '<td><img src ="'.$list["post_image"].'" width = 60 height = 60/></td>';
                                    echo '<td><a href="'.$list["full_link"].'" />Full link </a></td>';
                                    echo '<td><span >'.$list["at_page"].'</span></td>';
                                    echo '<td><span >'.$list["at_position"].'</span></td>';

                                    echo '<td><a href="'.$edit_url.'" class=" col-sm-4 btn btn-sm btn-info btn-flat pull-left">Edit</a>
                                          '.$status_button.'
                                          <a href= "'.$delete_url.'" class="col-sm-4 btn btn-sm btn-danger btn-flat pull-left">Delete</a>
                                          </td>';
                                   // echo '<td>'.$list['updated_at'].'</td>';
                                    echo '<tr>';

                                }
                            }
                            ?>


                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                {{$listData->links()}}
            </div>
        </div>


        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start -->
                <?php echo Form::open(array('route'=>$router['POST'],'method'=>'post','enctype'=>'multipart/form-data')) ?>
                {{--<form role="form">--}}
                <div class="box-header with-border">
                    <h3 class="box-title">New Category</h3>
                    @if (count($errors) > 0)
                        <div class="alert alert-success">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    @if(strpos($error,'Successful!'))
                                    <li style="color: #FFFFFF">{{ $error }}</li>
                                    @else
                                    <li style="color: red">{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="box-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Link</label>
                        <input type="input" name ="full_link" value = "<?php echo $update_data!=null?$update_data["full_link"]:""; ?>" class="form-control" id="exampleInputEmail1" >
                        <label for="exampleInputEmail1">Advertisement Host</label>
                        <input type="input" name ="ads_host" value = "<?php echo $update_data!=null?$update_data["ads_host"]:""; ?>" class="form-control" id="exampleInputEmail1" >
                        <label for="exampleInputEmail1">Advertisement Code</label>
                        <input type="input" name ="ads_code" value = "<?php echo $update_data!=null?$update_data["ads_code"]:""; ?>" class="form-control" id="exampleInputEmail1" >

                        <div class="form-group">

                         <label for="exampleInputEmail1">At page</label>
                         <input type="input" name ="at_page" value = "<?php echo $update_data!=null?$update_data["at_page"]:""; ?>" class="form-control" id="exampleInputEmail1" >
                         <label for="exampleInputEmail1">At position</label>
                         <input type="input" name ="at_position" value = "<?php echo $update_data!=null?$update_data["at_position"]:""; ?>" class="form-control" id="exampleInputEmail1" >

                         <div class="form-group">

                            <label for="exampleInputEmail1">Type</label>
                            <select class="form-control" name = "type">
                                @if($update_data!=null && $update_data['type'] == 2)
                                    <option value = "1" >News</option>
                                    <option value="2" selected>Social Network</option>
                                @else
                                    <option value = "1" selected>News</option>
                                    <option value="2" >Social Network</option>
                                 @endif
                            </select>

                        </div>
                         <div class="form-group">
                                <label for="exampleInputEmail1">Advertisement Image</label>
                                <input type="file" name ="post_image" class="form-control" id="exampleInputEmail1" >
                         </div>

                    </div>
                    <div class="checkbox">
                        <label>
                            @if($update_data!=null & $update_data['active'] == 1)
                                    <input type="checkbox" name="active" checked> Active
                            @else
                                <input type="checkbox" name="active"  > Active
                            @endif
                            @if($isEdit)
                                <input type="hidden" name = "id" value="<?php echo $update_data['id']?>">
                            @endif
                        </label>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    @if($isEdit)
                        &nbsp;&nbsp;&nbsp<a href="<?php echo url()->current() ?>" class="btn btn-warning" >Cancel</a>
                    @endif
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <?php echo Form::close() ?>
            </div>
            <!-- /.box -->
@endsection
