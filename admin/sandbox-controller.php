<?php 
global $content;

try {
if(!empty($_POST['action'])){

    if(!empty($_POST['sandbox']) && $_POST['action'] == 'create'){                      
            Sandbox::create($_POST['sandbox']);       
    }
       
    if(!empty($_POST['sandbox'])){
        $sandbox = Sandbox::getSandbox($_POST['sandbox']); 
        if($_POST['action'] == 'delete')
            $sandbox->delete();    
        if($_POST['action'] == 'download')
            $sandbox->download();    
        if($_POST['action'] == 'install')
            $sandbox->install($_POST['install']);    
    }        
}
} catch (Exception $e) {   
    $content['message'] = $e->getMessage();
}


$content['sandboxes'] = Sandbox::getSandboxes();