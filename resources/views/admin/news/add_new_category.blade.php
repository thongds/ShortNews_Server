@extends('../../layouts.admin')
@section('title','NewsPaper Name')
@section('content')
    <?php echo Form::open(array('route'=>'addNewCategory','method' => 'post'))?>
    <div class="form-group">
        <label for="exampleInputEmail1">Category Name</label>
        <input type="text" class="form-control" name="category_name" id="exampleInputEmail1" placeholder="newspaper name">
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name ="status" checked> active
        </label>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    <?php echo Form::close()?>
@endsection