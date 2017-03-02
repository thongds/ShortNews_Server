@extends('../../layouts.admin')
@section('title','NewsPaper Name')
@section('content')
        <?php echo Form::open(array('route'=>'addNewspaper','method' => 'post','enctype'=>'multipart/form-data'))?>
        <div class="form-group">
            <label for="exampleInputEmail1">NewsPaper Name</label>
            <input type="text" class="form-control" name="newspaper_name" id="exampleInputEmail1" placeholder="newspaper name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Newspaper logo</label>
            <input type="file"  name="newspaper_logo" id="exampleInputEmail1" >
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Video tag image </label>
            <input type="file"  name="video_tag_image"  id="exampleInputPassword1"/>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Title color</label>
            <input type="text" class="form-control" name="title_color" id="exampleInputEmail1" placeholder="title color">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Newspaper tag color </label>
            <input type="text" name="newspaper_tag_color" class="form-control" id="exampleInputPassword1" placeholder="tag color"/>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name ="status" checked> active
            </label>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    <?php echo Form::close()?>
@endsection