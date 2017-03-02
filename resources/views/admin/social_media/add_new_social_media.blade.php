@extends('../../layouts.admin')
@section('title','news media')
@section('content')
    <?php echo Form::open(array('route'=>'addNewSocialMedia','method' => 'post','enctype'=>'multipart/form-data'))?>
    <div class="form-group">
        <label for="exampleInputEmail1">Post title *</label>
        <input type="text" class="form-control" name="title" value="<?php echo $social_data !=null ?$social_data[0]->title:''; ?>" id="exampleInputEmail1" placeholder="post title">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">link url </label>
            <div class="form-group" id="input_fields_wrap">
                <?php
                    if($social_data!=null){
                        $array_image_ulr = explode("--inshortnews--",$social_data[0]->post_image_url);
                        foreach ( $array_image_ulr as $url){
                            if(!empty($url))
                                echo '<div><br><input type="text" class="form-control" value="'.$url.'" name="post_image_url[]"><a href="#" class="remove_field">Remove</a></div>';
                        }
                    }else{
                        //echo '<div><br><input type="text" class="form-control" name="post_image_url[]"></div>';
                    }

                ?>

            </div>
            <br>
            <button id="add_field_button" class="btn btn-danger" type="button" >Add More Links </button>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Full link *</label>
        <input name="full_link" value="<?php echo $social_data !=null ?$social_data[0]->full_link:''; ?>" class="form-control" >
    </div>

    <label > Fanpage</label>
    <select class="form-control" name="fanpage_id">
        <?php
            $selected_id = $social_data!=null?$social_data[0]->fan_page_id:-1;
        foreach ($fanpage as $data){
            $selected_text = '';
            if($selected_id == $data->id){
                $selected_text = "selected";
                echo ' <option value="'.$data->id.'"  selected="'.$selected_text.'">'.$data->name.'</option>';
            }else{
                echo ' <option value="'.$data->id.'" >'.$data->name.'</option>';
            }
        }
        ?>

    </select>
    <br>
    <label > Post type </label>
    <select class="form-control" name="social_content_type_id">
        <?php
        $social_content_type_id = $social_data!=null?$social_data[0]->social_content_type_id:-1;
        foreach ($social_content_type as $data){
            $selected_text = '';
            if($social_content_type_id == $data->id){
                $selected_text = "selected";
                echo ' <option value="'.$data->id.'"  selected="'.$selected_text.'">'.$data->name.'</option>';
            }else{
                echo ' <option value="'.$data->id.'" >'.$data->name.'</option>';
            }
        }
        ?>

    </select>
    <br>

    <br>
    <div class="checkbox">
        <label>
            <input type="checkbox" name ="status" checked> active
        </label>
    </div>
    <br>
    <input type="hidden" name="id" value="<?php echo $social_data!=null?$social_data[0]->id:'' ?>">
    <button type="submit" class="btn btn-success">Submit</button>
    <?php echo Form::close()?>
    <script>

        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $("#input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID

            var x = 1; //initlal text box count

            $(add_button).click(function(e){
                //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><br><input type="text" name="post_image_url[]" class="form-control"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
                }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault();
                $(this).parent('div').remove(); x--;
            })
        });
    </script>
@endsection
