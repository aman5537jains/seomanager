<a href="{{url('seo-manager/add')}}">Add</a>
<table border=1>
   
        <tr>
            <td>
                Url
            </td>
            <td>
                title
            </td>
            <td>
               Edit
            </td>
        </tr>
   
    <?php foreach( $list as $k=>$v){ ?>
    <tr>
                <td>
                   {{$v->url}}
                </td>
                <td>
                {{$v->meta_title}}
                </td>
                <td>
                <a href="{{url('seo-manager/edit/'.$v->id)}}">Edit</a>
                </td>
        </tr>
    <?php  } ?>
</table>