@extends('../layouts.admin')
@section('title','news setting')
@section('content')
    <br> <br> <a href="{{url('/admin/addnews')}}"> <button type="button" class="btn btn-success">Add newspaper</button><a href="{{url('/admin/addnewcategory')}}"> <button type="button" class="btn btn-warning">Add new category</button></a>
        <br><br>
        <table class="table table table-striped">
            <h2 style="color: #CC3300"><u>Newspaper</u> </h2>
            <thead>
            <tr>
                <th>Newspaper Name</th>
                <th>Newspaper Logo </th>
                <th>video tag</th>
                <th>title color</th>
                <th> paper tag color</th>
                <th> action </th>
            </tr>
            </thead>
            <tbody>
            <?php if($newspaper !=null):?>
            <tr>
                <?php
                foreach ($newspaper as $data){
                    $delete_url =url()->current().'?type=newspaper&delete=true&id='.$data->id;
                    $edit_url = url('/').'/admin/addnews?id='.$data->id;
                    if($data->status == 0){
                        $class = "danger";
                        $active_url =url()->current().'?type=newspaper&active=1&id='.$data->id;
                        $status_button = '&nbsp;<a href='.$active_url.' <button type="button" class="btn btn-success">active</button></a>';
                    }else{
                        $class = "";
                        $active_url =url()->current().'?type=newspaper&active=0&id='.$data->id;
                        $status_button = '&nbsp;<a href='.$active_url.' <button type="button" class="btn btn-warning">deactive</button></a>';
                    }

                    echo'<tr class ="'.$class.'">';
                    echo '<td>'.$data->newspaper_name.'</td>';
                    echo '<td> <img src="'.$data->paper_logo.'"style="width:80px;height:80px;"></td>';
                    echo '<td><img src="'.$data->video_tag_image.'" style="width:80px;height:80px;"></td>';
                    echo '<td><label style="color: '.$data->title_color.'">title color : '.$data->title_color.'<label></td>';
                    echo '<td><button style="color: '.$data->paper_tag_color.'">tag color : '.$data->paper_tag_color.'</button></td>';
                    echo '<td><a href='.$edit_url.'><button type="button" class="btn btn-success">edit</button></a>
                        <a href='.$delete_url.'><button type="button" class="btn btn-danger">delete</button></a>
                        '.$status_button.'
                    </td>';
                    echo '</tr>';
                }
                ?>
            </tr>
            <?php endif;?>
            </tbody>
        </table>
        {{ $newspaper->links() }}
        <br><br>
        <table class="table table table-striped">
            <h2 style="color: #CC3300"> <u>category </u></h2>
            <thead>
            <tr>
                <th>Name</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($category !=null):?>

            <?php
                foreach ($category as $data){
                    $class = '';
                    $delete_url =url()->current().'?type=category&delete=true&id='.$data->id;
                    $edit_url = url('/').'/admin/addnewsocial?id='.$data->id;
                    if($data->status == 0){
                        $class = "danger";
                        $active_url =url()->current().'?type=category&active=1&id='.$data->id;
                        $status_button = '&nbsp;<a href='.$active_url.' <button type="button" class="btn btn-success">active</button></a>';
                    }else{
                        $class = "";
                        $active_url =url()->current().'?type=category&active=0&id='.$data->id;
                        $status_button = '&nbsp;<a href='.$active_url.' <button type="button" class="btn btn-warning">deactive</button></a>';
                    }
                    echo'<tr class ="'.$class.'">';
                    echo '<td>'.$data->category_name.'</td>';

                    echo '<td><a href='.$edit_url.'><button type="button" class="btn btn-success">edit</button></a>
                        <a href='.$delete_url.'><button type="button" class="btn btn-danger">delete</button></a>
                        '.$status_button.'
                    </td>';
                    echo '</tr>';
                }
                ?>
        <? endif?>
            </tbody>
        </table>
    {{$category->links()}}





@endsection