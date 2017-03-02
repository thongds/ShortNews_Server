@extends('../../layouts.admin')
@section('title','news media')
@section('content')
<?php echo Form::open(array('route'=>'addNewsMedia','method' => 'post','enctype'=>'multipart/form-data'))?>
<div class="form-group">
    <label for="exampleInputEmail1">Post title *</label>
    <input type="text" class="form-control" name="post_title" value="<?php echo $update_data!=null ? $update_data[0]->post_title:'' ?>"  id="exampleInputEmail1" placeholder="post title">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Post content *</label>
    <textarea name="post_content" class="form-control" rows="6"><?php echo $update_data!=null ? $update_data[0]->post_content:'' ?></textarea>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Full link *</label>
    <input name="full_link"  value="<?php echo $update_data!=null ? $update_data[0]->full_link:'' ?>"  class="form-control" >
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Video link</label>
    <input name="video_link" value="<?php echo $update_data!=null ? $update_data[0]->video_link:'' ?>"  class="form-control" >
</div>
<div class="form-group">
    <label for="exampleInputPassword1">post image </label>
    <input type="text" value="<?php echo $update_data!=null ? $update_data[0]->post_image:'' ?>"    class="form-control" name="post_image"  id="exampleInputPassword1"/>
</div>
<label > Category </label>
<select class="form-control" name="category_id">
    <?php
        $id =-1;
        if($update_data !=null){
            $id = $update_data[0]->category_id;
        }
        foreach ($category as $data){
            if($id == $data->id)
                echo ' <option value="'.$data->id.'" selected ="selected">'.$data->category_name.'</option>';
            else
                echo ' <option value="'.$data->id.'">'.$data->category_name.'</option>';
        }
    ?>
</select>
<label > Newspaper</label>
<select class="form-control" name="newspaper_id">
    <?php
        $id =-1;
        if($update_data !=null){
            $id = $update_data[0]->newspaper_id;
        }
        foreach ($newspaper as $data){
            if($id == $data->id)
                echo ' <option value="'.$data->id.'" selected ="selected">'.$data->newspaper_name.'</option>';
            else
                echo ' <option value="'.$data->id.'">'.$data->newspaper_name.'</option>';
        }
    ?>

</select>
<br>
<div class="checkbox">
    <label>
        <?php
            if($update_data !=null && $update_data[0]->is_video == 1)
                echo ' <input type="checkbox" checked ="checked" name ="is_video" > Is video';
            else
               echo ' <input type="checkbox" name ="is_video" > Is video';
        ?>

    </label>
</div>
<br>
<div class="checkbox">
    <label>
        <input type="checkbox" name ="status" checked> active
    </label>
</div>
<br>
<input type="hidden" name="is_update" value="<?php echo $update_data !=null ?$update_data[0]->id:-1?>">
<button type="submit" class="btn btn-success">Submit</button>
<?php echo Form::close()?>
@endsection
<script>
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
</script>