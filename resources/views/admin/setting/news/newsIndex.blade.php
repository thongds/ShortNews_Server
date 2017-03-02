@extends('../layouts.admin')
@section('title','Singer Index')
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
                                <th>ID</th>
                                <th>Post Title</th>
                                <th>Post Content</th>
                                <th>Post Image</th>
                                <th>Full Link</th>
                                <th>Status</th>
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
                                        $status_button = '<a href='.$active_url.'  class=" col-sm-3 btn btn-sm btn-success btn-flat pull-left">Active</a>';
                                    }else{
                                        $class = "";
                                        $active_url =url()->current().'?page='.$page.'&active=0&id='.$list['id'];
                                        $status_button = '<a href='.$active_url.'  class=" col-sm-3 btn btn-sm btn-warning btn-flat pull-left">Deactive</a>';
                                    }
                                    echo '<tr class="'.$class.'">';
                                    echo '<td>'.$list['id'].'</td>';
                                    echo '<td class="col-md-2">'.$list['post_title'].'</td>';
                                    echo '<td class="col-md-2">'.$list['post_content'].'</td>';
                                    echo '<td><img width="100" height="100" src="'.$list['post_image'].'"></td>';
                                    echo '<td><a href="'.$list['full_link'].'">Full Link</a></td>';
                                    $labeClass = $list['active']?"label-success" : "label-danger";
                                    $labeName = $list['active']?"Active" : "Block";


                                    echo '<td><span class="label '.$labeClass.'">'.$labeName.'</span></td>';
                                    echo '<td><a href="'.$edit_url.'" class=" col-sm-3 btn btn-sm btn-info btn-flat pull-left">Edit</a>
                                          '.$status_button.'
                                          <a href= "'.$delete_url.'" class="col-sm-3 btn btn-sm btn-danger btn-flat pull-left">Delete</a>
                                          </td>';

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
                <?php echo Form::open(array('route'=> $router['POST'],'method'=>'post','enctype'=>'multipart/form-data')) ?>
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
                        <label for="exampleInputEmail1">Post title</label>
                        <input type="input" name ="post_title" value = "<?php echo $update_data!=null?$update_data["post_title"]:""; ?>"
                               class="form-control" id="exampleInputEmail1" placeholder="News title" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Post Content</label>
                        <textarea type="input" rows="5"  name ="post_content"  class="form-control" id="exampleInputEmail1"
                        placeholder="Duration"><?php echo $update_data!=null?$update_data["post_content"]:""; ?> </textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Post Image</label>
                        <input type="input" name ="post_image" value = "<?php echo $update_data!=null?$update_data["post_image"]:""; ?>"
                               class="form-control" id="exampleInputEmail1" placeholder="Post Image" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Video Link</label>
                        <input type="input" name ="video_link" value = "<?php echo $update_data!=null?$update_data["video_link"]:""; ?>"
                               class="form-control" id="exampleInputEmail1" placeholder="Video Link" >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Link</label>
                        <input type="input" name ="full_link" value = "<?php echo $update_data!=null?$update_data["full_link"]:""; ?>"
                               class="form-control" id="exampleInputEmail1" placeholder="Full Link" >
                    </div>

                    @if(isset($foreignData) && $foreignData != null)
                        @foreach($foreignData as $key => $value)
                        <label > <? echo $value['label'] ?></label>
                        <select class="form-control" name=<? echo $value['fr_id'] ?>>
                            <?php
                            $id =-1;
                            if($update_data !=null){
                                $id = $update_data[$value['fr_id']];
                            }
                            foreach ($value['fr_data'] as $data){
                                if($id == $data['id'])
                                    echo ' <option value="'.$data['id'].'" selected ="selected">'.$data[$value['fr_select_field']].'</option>';
                                else
                                    echo ' <option value="'.$data['id'].'">'.$data[$value['fr_select_field']].'</option>';
                            }
                            ?>

                        </select>
                        @endforeach
                    @endif
                    <br>

                    <div class="checkbox">
                        <label>
                            @if($update_data!=null & $update_data['is_video'] != 1)
                                <input type="checkbox" name="is_video" > Is video ?
                            @else
                                <input type="checkbox" name="is_video" > Is video ?
                            @endif

                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            @if($update_data!=null & $update_data['active'] != 1)
                                <input type="checkbox" name="active" > Active
                            @else
                                <input type="checkbox" name="active" checked > Active
                            @endif

                        </label>
                    </div>
                    @if($isEdit)
                        <input type="hidden" name = "id" value="<?php echo $update_data['id']?>">
                    @endif
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    @if($isEdit)
                        &nbsp;&nbsp;&nbsp;&nbsp<a href="<?php echo url()->current() ?>" class="btn btn-warning" >Cancel</a>
                    @endif
                </div>
                <?php echo Form::close() ?>
            </div>
            <!-- /.box -->
@endsection
