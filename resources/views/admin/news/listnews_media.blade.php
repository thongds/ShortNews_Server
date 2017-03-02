@extends('../../layouts.admin')
@section('title','list news')
@section('content')
   <a href="{{url('/admin/addnewsmedia')}}"> <button type="button" class="btn btn-success">Add news</button></a>
   <br><br>
   <table class="table table table-striped">

       <thead>
       <tr>
           <th class="col-xs-2">post title</th>
           <th class="col-xs-3">post content </th>
           <th class="col-xs-2">full link</th>
           <th class="col-xs-2">post image</th>
           <th class="col-xs-2"> link video</th>
           <th class="col-xs-3"> action </th>
       </tr>
       </thead>
       <tbody>

       <tr>
           <?php

           foreach ($news as $data){
               $delete_url =url()->current().'?type=news&page='.$page.'&delete=true&id='.$data->id;
               $edit_url = url('/').'/admin/addnewsmedia?id='.$data->id;
               if($data->status == 0){
                   $class = "danger";
                   $active_url =url()->current().'?type=news&page='.$page.'&active=1&id='.$data->id;
                   $status_button = '&nbsp;<a href='.$active_url.' <button type="button" class="btn btn-success">active</button></a>';
               }else{
                   $class = "";
                   $active_url =url()->current().'?type=news&page='.$page.'&active=0&id='.$data->id;
                   $status_button = '&nbsp;<a href='.$active_url.' <button type="button" class="btn btn-warning">deactive</button></a>';
               }
               $color =str_word_count($data->post_content)>100? '#D0021B' : '#165CAE';
               echo'<tr class ="'.$class.'">';
               echo '<td>'.$data->post_title.'</td>';
               echo '<td>'.$data->post_content.'<br><br><label style="color :'.$color.'">'. str_word_count($data->post_content).' words</label></td>';
               echo '<td><a href="'.$data->full_link.'">click to open full link</a></td>';
               echo '<td> <a href="'.$data->post_image.'"> <img src="'.$data->post_image.'"style="width:80px;height:80px;"></a></td>';
               if($data->video_link!='')
                    echo '<td><video width="200" height="200" controls><source src="'.$data->video_link.'"></video></td>';
               else
                   echo '<td></td>';
               echo '<td><a href='.$edit_url.'><button type="button" class="btn btn-success">edit</button></a><br><br><a href='.$delete_url.'><button type="button" class="btn btn-danger">delete</button></a></br><br>
                        '.$status_button.'
                    </td>';
               echo '</tr>';
           }
           ?>
       </tr>
       </tbody>
   </table>
{{$news->links()}}



@endsection