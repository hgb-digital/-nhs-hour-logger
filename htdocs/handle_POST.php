<?php

function http_return(string $redirect_var, bool $success = false) {
    $directory = "";
    $split = explode(".", $redirect_var);
    if (sizeof($split) > 1) {
        $directory = $split[0] . "/";
        $redirect_var = $split[1];
    } else {
        $redirect_var = $split[0];
    }

    if ($success) {
        $redirect_var = $redirect_var . "&result=success";
    }

    header('Location: /' . $directory . '?url=' . $redirect_var);
    die();
}

function send_errors($errors, $redirect, $js, $form_sendback = null) {
    if (!$js) {
        $_SESSION['form_errors'] = $errors;
        if (isset($form_sendback)) {
            $_SESSION['form_sendback'] = $form_sendback;
        }

        http_return($redirect);
    } else {
        echo json_encode(["errors" => $errors]);
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "../private/maintenance.php";

    if ($maintenance) {
        http_response_code(503);
        die();
    }

    include_once(realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/dbh_manager.php"));
    include_once(realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/config_session.php"));
    #error_reporting(0);

    #get data
    $data_to_send = file_get_contents('php://input');

    #convert data to JSON
    $decoded_json = json_decode($data_to_send, true);

    //decides whether a redirect is necessary (js runs behind the scenes)
    $js_request = true;
    
    if ($decoded_json === null) {
        $decoded_json = $_POST;
        $js_request = false;

        $data = [];
        $data['data'] = [];
        foreach ($decoded_json as $detail => $value) {
            if (in_array($detail, ['request', 'redirect'])) {
                $data[$detail] = $value;
            } else {
                $data['data'][$detail] = $value;
            }
        }

    } else {
        $data = $decoded_json;
    }

    include_once(realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php"));

    #call function
    if (!isset($data['request']) || !isset($data['data'])) {
        send_errors(["internal_server"], isset($data['redirect']) ? $data['redirect'] : 'home', $js_request);
    }

    
    //function:user permission, permissions cascade, admin > officer > chair > member, if null then no permissions required
    $form_functions = ['login' => null, 'signup' => null, 'logout' => 'member', 'alter_user' => 'admin', 'update_server_messages' => 'admin',
    "set_password" => null, "log_hours" => 'member', "create_service" => 'chair', "signup_service" => 'member', "edit_hour" => 'member', 
    'send_password_reset' => null, 'set_messages'=> 'admin', "set_announcement" => 'officer'];
        
    $functions  = $form_functions;

    if (!key_exists($data['request'], $functions)) {
        send_errors(["internal_server"], isset($data['redirect']) ? $data['redirect'] : 'home', $js_request);
    }

    //ensure proper permissions
    $authorized = false;
    
    switch ($functions[$data['request']]) {
        case null:
            $authorized = true;
            break;
        case 'admin':
            if (isset($_SESSION['user_id']) && $_SESSION['user_permissions'] === 'admin') {
                $authorized = true;
            }
            break;

        case 'officer':
            if (isset($_SESSION['user_id'])) {
                if (in_array($_SESSION['user_permissions'], ['admin', 'officer'])) {
                    $authorized = true;
                }
            }
            
            break;
        
        case 'chair':
            if (isset($_SESSION['user_id'])) {
                if (in_array($_SESSION['user_permissions'], ['admin', 'officer', 'chair'])) {
                    $authorized = true;
                }
            }
            
            break;
        
        case 'member':
            if (isset($_SESSION['user_id'])) {
                $authorized = true;
                if ($_SESSION['user_permissions'] == 'admin') {
                    if (!isset($data['data']['user_id'])) {
                        $data['data']['user_id'] = $_SESSION['user_id'];
                    }
                    break;
                }

                //ensures that the user is only operating for themselves and NOT another id
                $data['data']['user_id'] = $_SESSION['user_id'];
            }
            break;
    }

    if (!$authorized) {
        send_errors(["not_authorized"], isset($data['redirect']) ? $data['redirect'] : 'home', $js_request);
    }


    switch ($data['request']) {
        case 'login':
            $path = realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/login/login_script.php");
            include($path);
            break;

        case 'signup':
            $path = realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/signup/signup.php");
            include($path);
            break;

        case 'logout':
            $path = realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/login/logout.php");
            include($path);
            break;
        
        default:
            include(realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/". 'web_managment/' . $data['request'] . ".php"));
            break;
    }

    $return = call_user_func($data['request'], $data['data']);

    //handle errors
    //will return an array of errors and their id (eg. empty_input), 
    //this will be sent to a session variable that the returning file will process
    if (!($return === true)) {
        if (isset($return['errors'])) {
            send_errors($return['errors'], $data['redirect'] ?? null, $js_request, isset($data['form_sendback']) ? $data['form_sendback'] : null);
        } elseif (isset($return['data'])) {
            echo json_encode($return['data']);
        } else {
            send_errors(['internal_server'], $data['redirect'] ?? null, $js_request);
        }
    } else {
        echo json_encode([]);
    }
    
    if (!$js_request) {
        http_return($data['redirect'], true);
    }

    die();

} else {
    header('Location: /');
    die();
}