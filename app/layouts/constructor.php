<?php   if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){  header('content-type=text','',404);die();}

use Adapter\App\Log;
use System\Html\Views\BreadcrumbView;
use System\Enums\UserType;

$_system403=true;
$_system404=true;

//if url matched (means page/script exists)
if(isset($match) && isset($match['target'])){
    $_system404=false;
    /**
     * This section checks user authorization and access
     * If user not pass from here then view system warning (403|404) page and die
     */
    switch($match['target']['c']){

        case 'user':
            if(isset($_user)){
                if($_user_auth->CheckAuthentication('', $_user->getType() == UserType::User || $_user->getType() == UserType::Manager)){
                    $_system403 = false;
                }
            }
            else{
                app::redirect($router->generate('auth_login'));
            }
            break;

        case 'management':
            if(isset($_user)){

                //if user authenticated then ok else out 404(Means user not authenticated or not have access)
                if($_user_auth->CheckAuthentication('',$_user->getType()==UserType::Manager)){

                    $_system403=false;

                    //if not access key entered
                    if($_user->checkAccessKey()==false){
                        if($match['name']!=='man_access' && $match['name']!=='man_check_access'){
                            app::redirect($router->generate('man_access'));
                            die();
                        }
                    }
                    else{
                        if($match['name']=='man_access' || $match['name']=='man_check_access'){
                            $_system404=true;
                        }
                    }
                }
                else{
                    $_system403=true;
                }
            }
            break;

        case 'observer':
            if(isset($_user)){

                if($_user_auth->CheckAuthentication('',$_user->getType()==UserType::Observer)){
                    $_system403=false;
                }
                else{
                    $_system403=true;
                }
            }
            break;

        case 'editor':
            if(isset($_user)){

                if($_user_auth->CheckAuthentication('',$_user->getType()==UserType::Editor)){
                    $_system403=false;
                }
                else{
                    $_system403=true;
                }
            }
            break;

        case 'ajax':
            $_system403=false;
            break;

        case 'assessment':
            if($_user_auth->CheckAuthentication()){
                $_system403 = false;
            }
            else{
                app::redirect($router->generate('auth_login'));
            }
            break;

        case 'app':
        case 'auth':
        case 'default':
        case 'article':
        case 'category':
        case 'news':
        case 'letter':
            $_system403=false;
            break;
    }
}
else{
    $_system404=true;
}
if(!$_user_auth->CheckAuthentication() && $_system403){
    $_system403=false;
    $_system404=true;
    app::redirect($router->generate('auth_login'));
}
/**
 * AppLog
 * @var $appLog
 */
if($match['name']!=='app_igx_request_lib'){
    $status=200;

    if($_system403==true) $status=403;
    if($_system404==true) $status=404;

    $appLog=new Log($_connection);
    $appLog->addConstructorLog($status);
}

//view 404 page and die.
if($_system404==true){
    sys::_404();
    die();
}

//view 403 page and die.
if($_system403==true){
    sys::_403();
    die();
}

/**
 *
 */
$_action_path=$match['target']['a'];
$_action_type=$match['type'];

/**
 * Load and view requested layout (page/form)
 * this section control point for: out page (with the exception of system layouts), do action or redirect.
 */
if($_action_type=='form')
{
    //prepares BreadcrumbView, all time. How use: $breadcrumb->render();
    $breadcrumb=new BreadcrumbView('','','');
    $breadcrumb->setItems(ViewExt::BreadcrumbItems($router,$match));
    //load layout (page/form)
    include app::scriptLink($_action_path);
    include app::formLink($_action_path);
}
elseif($_action_type=='action')
{
    //includes action script. Usually can use in html form action handler
    include app::actionLink($_action_path);
}
elseif($_action_type=='ajax')
{
    include app::actionLink('/ajax/constructor.php');
}
elseif($_action_type=='redirect')
{
    //redirect to need page ($_action_path) from requested page
    app::redirect($router->generate($_action_path));
}
elseif($_action_type=='redirect_link')
{
    //redirect to need page ($_action_path) from requested page
    app::redirect($_action_path);
}



