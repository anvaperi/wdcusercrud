<?php include_once 'includes/init.php'; ?>
<?php
	if (!checkToken($_POST['token']))	{
		die('token incorrecto');
	}
	foreach ($_POST as $key => $value) {
		$_POST[$key] = filter_var($_POST[$key], FILTER_SANITIZE_STRING);
	}
	// unset($_SESSION['token']);
	
  try {

		//$user = new User($_POST);
		//$response = $user->updateUser();
		//echo $response;
		//echo "<script>console.log($response)</script>";

    switch($_POST['action']) {
      case 'update':
        $user = new User($_POST);
        $response = $user->updateUser();
        echo $response;
        break;
      case 'add':
        $user = new User($_POST);
        $response = $user->addUser();
        echo $response;
        //echo registerUser($_POST);
        break;
      case 'delete':
        $response = User::deleteUsers($_POST['ids']);
        echo $response;
        break;
      default:
        throw new Exception('Invalid action');
    }
  } catch (Exception $error) {
    http_response_code(500);
    echo 'Excepción: ',  $error->getMessage(), "\n";
  }
  // registerUser($_POST);
    
	function registerUser($params) {
		$newUser = new User($params);
		echo $newUser->addUser();
	}
?>
