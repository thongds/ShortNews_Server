@extends('../../layouts.admin')
@section('title','list social')
@section('content')
    <a href="{{url('/admin/addnewsocialmedia')}}"> <button type="button" class="btn btn-success">Add news</button></a>
    <br><br>
    <table class="table table table-striped">

        <thead>
        <tr>
            <th class="col-xs-2">Title</th>
            <th class="col-xs-2">link data </th>
            <th class="col-xs-2">full link</th>
            <th class="col-xs-2"> action </th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <?php
            foreach ($socialmedia as $data){
                $delete_url =url()->current().'?type=social&delete=true&id='.$data->id;
                $edit_url = url('/').'/admin/addnewsocialmedia?id='.$data->id;
                if($data->status == 0){
                    $class = "danger";
                    $active_url =url()->current().'?type=social&active=1&id='.$data->id;
                    $status_button = '<a href='.$active_url.' <button type="button" class="btn btn-success">active</button></a>';
                }else{
                    $class = "";
                    $active_url =url()->current().'?type=social&active=0&id='.$data->id;
                    $status_button = '<a href='.$active_url.' <button type="button" class="btn btn-warning">deactive</button></a>';
                }

                $post_url = explode("--inshortnews--",$data->post_image_url);

                echo'<tr class ="'.$class.'">';
                echo '<td>'.$data->title.'</td>';
                echo'<td>';
                $i =0;
                foreach ($post_url as $url){

                    if(!empty($url) && $data->social_content_type_id != 0)
                            echo '<a href="'.$url.'" ><img src="'.$url.'" style="width:60px;height:60px"/></a>';
                    else{
                        if($i == 0)
                            echo '<a href ="'.$url.'" >click to open video</a>';
                        else if(!empty($url))
                            echo '<a href="'.$url.'" ><img src="'.$url.'" style="width:60px;height:60px"/></a>';
                    }
                    $i++;
                }
                echo '</td>';
                if($data->full_link!=null)
                    echo '<td><a href="'.$data->full_link.'">click to open full link</a></td>';
                else
                    echo '<td> link empty</td>';

                echo '<td>
                        <a href='.$edit_url.'><button type="button" class="btn btn-success">edit</button></a>
                        <a href='.$delete_url.'><button type="button" class="btn btn-danger">delete</button></a>
                        '.$status_button.'
                     </td>';
                echo '</tr>';
            }
            ?>
        </tr>
        </tbody>
    </table>
    {{ $socialmedia->links() }}



@endsection