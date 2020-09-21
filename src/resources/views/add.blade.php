
 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <a href="{{url('seo-manager')}}">List</a>
<div class="container-fluid">
    <form method="post" action="{{url('seo-manager/add-post')}}">
        
        <div class="row">

               
            
            
                <div class="col-6"> 
                       
                        <div class="form-group">
                            <label for="exampleInputEmail1">URL</label>
                            <input name="edit_id" value="{{$detail->id}}" class="form-control" type='hidden' placeholder="URL"  >
                            <!-- <input value="{{$detail->url}}" class="form-control" placeholder="URL" id="url"> -->
                          
                            <select class='form-control' value="{{$detail->url}}" name="url"  id="url"   >
                            <?php foreach($routes as $route){ ?>
                                <option  {{$detail->url==$route?'selected':''}} >{{$route}}</option>
                            <?php  } ?> 
                            </select>
                         
                            <small id="emailHelp" class="form-text text-muted">Enter the route url.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta Title</label>
                        
                            <input name="meta_title" value="{{$detail->meta_title}}" class="form-control" placeholder="Meta Title" >
                        
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta Keyword</label>
                        
                            <input name="meta_keyword" value="{{$detail->meta_keyword}}" class="form-control" placeholder="Meta Keyword"  >
                            
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meta Description</label>
                        
                            <input name="meta_description" value="{{$detail->meta_description}}" class="form-control" placeholder="Meta Description"  >
                        
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Author</label>
                        
                            <input name="author" value="{{$detail->author}}" class="form-control" placeholder="Author"  >
                        
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Canonical Url</label>
                        
                            <input name="canonical_url" value="{{$detail->canonical_url}}" class="form-control" placeholder="Canonical Url"  >
                        
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Type</label>
                        
                            <select class='form-control' value="{{$detail->type}}" name='type'  onchange='setValue("e",this)' >
                            <option   >DYNAMIC</option>
                            <option  >FIX</option>
                            </select>
                        
                        </div>
                </div>
                <div class="col-4">
                    <div id="params">

                        Params : <br>

                       
                    </div>
                </div>
            



                
        </div>
        <div class='row'>
            <div class="col-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
                 
            </div>
        </div>
    </form>
</div>
<style>
.paramvalue{display:none}
.suggestions{
    border:1px solid grey;
    position:absolute;
    z-index:9999;
    width:90%;
    background: white;
}
.bdr{
    border-bottom:1px solid grey;
padding:5px;    

}
</style>
<!-- <script
  src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
  crossorigin="anonymous"></script> -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script>
   
     var models  =   JSON.parse('{!!\Aman5537jains\SeoManager\SeoManager::tablesView('models')!!}');
  var getModelValue=function(model,e){
      
      var paramHtml="<option value=''>Model Column to Map With</option>";
      
      for(var model of models[model]){
          paramHtml+="<option>"+model+"</option> ";
      }
       $(e).next(".parammodelvalue").html(paramHtml);
      return paramHtml;
  }
  var setValue=function(val,e){
      
      
   
      if($(e).val()=="DYNAMIC")
           $(".paramvalue").hide();
        else
           $(".paramvalue").show();
      
  }
    function findParams(str){
        var s = str;
//         var re = /{(.*)}/g;
// // var arrStr = s.match("");
// console.log(s.match(new RegExp("{" + "(.*)" + "}")));
        var alllist=[];
        var strfill="";
        var startStrfill=false;
        for(var sb of str){
             
            if(sb=="}"){
                startStrfill=false;
                alllist.push({"key":"{"+strfill+"}",value:strfill});
                strfill='';

            }
            if(startStrfill){
                strfill+=sb;
            }
            if(sb=="{"){
                startStrfill=true;
            }
            
           
                
        }
        console.log(alllist);
        return alllist;
    }

  function buildParams(e){
    console.log(models);
        var val=$(e).val();
        var params=findParams(val);
        var paramHtml="";

        
        var models="<select name='parammodel[]'   > ";

        for(var param of params){
            paramHtml+="<p>"+param.value+"</p> <input name='param[]' value='"+param.value+"' type='hidden'  > "
            +getModels()+" <select    name='parammodelvalue[]'  id='parammodelvalue_"+param.value+"' class='parammodelvalue form-control' ></select> <input  autocomplete='off'  class='paramvalue form-control' id='paramvalue_"+param.value+"' name='paramvalue[]' placeholder='Model value'  > <br> ";
        }

        $("#params").html(paramHtml);
  }
  var getModels=function(selected=''){
       
       var paramHtml="";
       paramHtml+="<select class='form-control models' name='parammodel[]' onchange='getModelValue(this.value,this)'><option value=''>Select model</option>";
       for(var model in models){
           paramHtml+="<option  "+(model==selected?'selected':'')+">"+model+"</option> ";
       }
       paramHtml+="</select>";
       return paramHtml;
   }
  
  $(function(){
    var timeclr;
    $(document).on("keyup",".paramvalue",function(){
        
        if(timeclr){
            clearTimeout(timeclr);
            timeclr=false;
        }
        var e=this;
        var col=$(this).prev().val();
        var str=$(this).val();
        var mdl=$(this).prev().prev().val();

        timeclr = setTimeout(function(){

       
        $.get("{{url('seo-manager/suggestions')}}?mdl="+mdl+"&col="+col+"&str="+str,function(data){
 
            var hmtld="<div class='suggestions'>";
            for(var names of data){
                hmtld+="<div class='bdr' >"+ names[col]+"</div>";
            }
            hmtld+="</div >";
            $(e).next(".suggestions").remove();
            $(hmtld).insertAfter($(e))
        })
    },500) 
    })

    $(document).on("click",".bdr",function(){
        $(this).parent().prev().val($(this).html());
        $(this).parent().remove();
    });
 
    $(document).on("focusout","#url",function(){
       
       
        buildParams(this);
        setValue("","[name='type']")
    })
    <?php  if($params){
        echo "var parsm=JSON.parse('".json_encode($params)."')";
        ?>
        
         buildParams('#url');
         $("[name='type']").val('{{$detail->type}}');
         $("[name='type']").val()
        
         $(".models").each(function(k,i){
 
             $(this).val(parsm[k].param_model)
             $(this).change()
             $("#parammodelvalue_"+parsm[k].param).val(parsm[k].param_model_value)
             if($("[name='type']").val()=="FIX"){
                $(".paramvalue").show();
                $("#paramvalue_"+parsm[k].param).val(parsm[k].param_value);
              }
         })

        

         

<?php    }?>
   

    



  })
  </script>
  