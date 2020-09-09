<?php

namespace Aman5537jains\SeoManager;

use Aman5537jains\SeoManager\Model\SeoManager as SM;
use Aman5537jains\SeoManager\Model\SeoManagerParam as SMP;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class SeoManager 
{
  
    public function db()
    {
        return new SM();
    }

    public  static function config($name)
    {
        
        return  config("seoconfig.".$name);
    }


    public static function getTableColumns($name) {
        $namobj=new $name();
         
        return $namobj->getConnection()->getSchemaBuilder()->getColumnListing($namobj->getTable());
    }

    public  static function tablesView($s)
    {   
       $json=[]; 
     
       foreach(  self::config("models") as $name=>$model){
     
           $json[$name]=SeoManager::getTableColumns($model);
       }
        return   json_encode( $json);
    }

    
    public function listView()
    {
           return view("seomanager::list",["list"=> SM::paginate()]);
    }


    public function addView($id="")
    {        
            if($id==""){
                return view("seomanager::add",["detail"=> new SM(),"params"=>false]);
            }
            else
                return view("seomanager::add",["detail"=> SM::find($id),"params"=>SMP::where("seo_manager_id",$id)->get()]);
    }

    public function saveManager(Request $request)
    {       
            
        $validator = Validator::make($request->all(), [
            'url'               => 'required',
            // 'has_params'        => 'required',
            'meta_title'        => 'required',
            'meta_keyword'      => 'required',
            'meta_description'  => 'required',
            'type'              => 'required',
            "parammodel"        => is_null($request->param) || count($request->param)>0?'required|array':"",
            "parammodel.*"      => is_null($request->param) ||  count($request->param)>0?'required':"",
            "parammodelvalue"        => is_null($request->param) || count($request->param)>0?'required|array':"",
            "parammodelvalue.*" => is_null($request->param) || count($request->param)>0?'required':"",
            "paramvalue"        => $request->type=='FIX'?'required|array':"",
            "paramvalue.*"     =>$request->type=='FIX'?'required':"",
            
            
            
            ]);
        if ($validator->fails()) 
        {
            return ["status"=>false,"erros"=>$validator->errors(),"msg"=>"some errors in the form"];
        }
        else if($this->isAlreadyExist($request)>0){
            return ["status"=>false,"msg"=>"seo data already exist for url"];
        }
        else
        {

            if($request->edit_id=="")
                $row = new SM();
            else{
                $row =   SM::find($request->edit_id);
                SMP::where("seo_manager_id",$request->edit_id)->delete();
            }
            $row->url= $request->url;
            $row->re_url= $request->url;
            $row->has_params='1';//$request->title;
            $row->type=$request->type;
            $row->meta_title=$request->meta_title;
            $row->meta_keyword=$request->meta_keyword;
            $row->meta_description=$request->meta_description;
              $row->save();

            if(count($request->param)>0){
                foreach($request->param as $k=>$name){

                    $SMP=new SMP;
                    $SMP->seo_manager_id    = $row->id;
                    $SMP->param             = $name;
                    // $SMP->param_type        = $request->type;
                    $SMP->param_model       = $request->parammodel[$k];
                    $SMP->param_model_value = $request->parammodelvalue[$k];
                    $SMP->param_value       = $request->paramvalue[$k]==null || $request->paramvalue[$k]=='' ?"":$request->paramvalue[$k];
                    $SMP->save();

                    $request->url=     str_replace("{".$name."}", $SMP->param_value ,$request->url);

                }
                $row->re_url=$request->url;
                $row->save();
            }

            return ["status"=>true,"erros"=>"","msg"=>"Success",'details'=> $row];
        }
    }


    public function getPageMeta(Request $request)
    {       
        $haveTag=0; 
        $route  = \Route::current();

          $name   = \Route::currentRouteName();
        
          $action = \Route::currentRouteAction();
           
        $SMTag=SM::where("re_url",$request->path())->count();
        if(SM::where("re_url",$request->path())->count()>0){
            $haveTag= SM::where("re_url",$request->path())->first();
        }
        else if(SM::where("url",$route->uri)->count()>0){
            $haveTag=  SM::where("url",$route->uri)->first();
        }

        // $SMTag=SM::where("url",$route->uri);
        // if(count($route->parameters)>0){
        //     $newstag= $SMTag->leftJoin("seo_manager_params","seo_managers.id","seo_manager_id");
        //     $SMTag->where(function($sql1) use ($route){
                 
           
        //         foreach($route->parameters as $key=>$param){
        //             $sql1->orWhere(function($sql) use ($key,$param){
        //                 $sql->where("param",$key)->where("param_value",\DB::raw("if(param_type='DYNAMIC',param_value,'$param')"));
        //             }); 
                
        //         }
        //     }); 
           
        //     $SMTag=$SMTag->groupBy("seo_manager_id")->havingRaw("count(seo_manager_id1)=".count($route->parameters));
 
        //     if($SMTag->count()>0){
        //         $haveTag= $SMTag->select("seo_managers.*")->first();
        //     }
        //     else{
        //         $SMTag=SM::where("url",$route->uri);
        //         $newstag= $SMTag->leftJoin("seo_manager_params","seo_managers.id","seo_manager_id");
        //         $SMTag->where(function($sql1) use ($route){
                 
           
        //             foreach($route->parameters as $key=>$param){
        //                 $sql1->orWhere(function($sql) use ($key,$param){
        //                     $sql->where("param",$key)->where("param_type",'DYNAMIC');
        //                 }); 
                    
        //             }
        //         }); 
        //         $SMTag=$SMTag->groupBy("seo_manager_id")->havingRaw("count(seo_manager_id)=".count($route->parameters));
        //         $haveTag= $newstag->select("seo_managers.*")->first();
        //     }

        // }
        // else{
        //     $haveTag= $SMTag->first(); 
        // }   
       
        if($haveTag){
            $all_details=["havetag"=>$haveTag];
            $models=self::config("models");
            
            $params=SMP::where("seo_manager_id",$haveTag->id);
            if($params->count()>0){
                $allParams=$params->get();
                foreach($allParams as $allParam){
                     
                    $paramModel=new $models[$allParam->param_model]();
                    $all_details[$allParam->param_model]= $paramModel->where($allParam->param_model_value,$request->{$allParam->param})->first();
                    if($all_details[$allParam->param_model]){
                        foreach($all_details[$allParam->param_model]->toArray() as $key=>$value){
                    //  echo '{'.$allParam->param_model.'->'.$key.'}';
                            $haveTag->meta_title=str_replace('{'.$allParam->param_model.'.'.$key.'}',$value,$haveTag->meta_title);
                            $haveTag->meta_keyword=str_replace('{'.$allParam->param_model.'.'.$key.'}',$value,$haveTag->meta_keyword);
                            $haveTag->meta_description=str_replace('{'.$allParam->param_model.'.'.$key.'}',$value,$haveTag->meta_description);
                            

                        }
                    }
                     
                }
            }
             
           

            $all_details['havetag']=$haveTag;
             return $all_details;
        }
        else{
            return [];
        }
       
 
       
    }


    public function isAlreadyExist(Request $request)
    {       
        $haveTag=0; 
        $reurl=$request->url;

        
        
            if(count($request->param)>0){
                foreach($request->param as $k=>$name){

                     $vale=$request->paramvalue[$k]==null || $request->paramvalue[$k]=='' ?"":$request->paramvalue[$k];
                
                     $reurl=str_replace("{".$name."}", $vale,$reurl);
                     
                }
                
                
            }
         
        return SM::where("re_url",$reurl)->where("id","!=",$request->edit_id)->count();
       
    }
    public function cannotEmptyParam(Request $request)
    {       
        $haveTag=0; 
        $reurl=$request->url;

        
        
            if(count($request->param)>0){
                foreach($request->param as $k=>$name){

                     $vale=$request->paramvalue[$k]==null || $request->paramvalue[$k]=='' ?"":$request->paramvalue[$k];
                     $reurl= $request->url=str_replace("\{$name\}", $vale,$reurl);

                }
                
                
            }
        return SM::where("re_url",$reurl)->count();
       
    }




}
