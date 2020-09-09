<a href="{{url('seo-manager/add')}}">Add</a>
<table border=1>
   
        <tr>
            <td>
                Url
            </td>
            <td>
                title
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
        </tr>
    <?php  } ?>
</table>