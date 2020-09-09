<?php
namespace Aman\SeoManager\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aman\SeoManager\Model\SeoManager as SM;
use Aman\SeoManager\SeoManager as SMM;

use Illuminate\Support\Facades\Validator;
 

class SeoManager2Controller extends Controller
{
    private $seoManager;

    function __construct(){
       $this->seoManager= new SMM();
    //    dd();
    }
    public function show()
    {
        return $this->seoManager->listView();
    }
    public function add($id='')
    {
        return $this->seoManager->addView($id);
    }
    public function addPost(Request $request)
    {   
        
        return $this->seoManager->saveManager($request);
    }
    
    public function checkurl(Request $request)
    {   
        
        return $this->seoManager->getPageMeta($request);
    }
    
   

    
    




}
