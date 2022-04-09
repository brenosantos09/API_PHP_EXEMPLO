<?php
include_once "./config/config.php";

require_once "./app/services/DAO.php";
require_once "./app/models/usuario.php";
require_once "./app/controller/usuarioController.php";

//phpinfo();
try {
    if (count($_REQUEST) == 0) throw new Exception();

    $method = $_SERVER["REQUEST_METHOD"];

    $url = explode("/", $_GET["url"]);
    //localhost/api/usuario/list
    //localhost/api/usuario/get/1
    //var_dump($url);

    $result = null;
    //Pesquisa
    if ($method == "GET") {
        header("Content-Type: application/json; charset=UTF-8");

        switch ($url[0]) {
            case "usuario":
                switch ($url[1]) {
                    case "get": {
                            if (!isset($url[2])) throw new Exception();
                            $userController = new usuarioController;
                            $result = $userController->get($url[2]);
                        }
                        break;

                    case "list": {
                            $userController = new usuarioController;
                            $result = $userController->getAll();
                        }
                        break;

                    default:
                        throw new Exception();
                        break;
                }
                break;

            case "produto":
                break;

            default:
                throw new Exception();
                break;
        }

        http_response_code(200);
        echo json_encode(array("result" => $result));
    }

    //Cadastros e Atualizações
    if ($method == "POST") {
        header("Content-Type: application/json; charset=UTF-8");
        switch ($url[0]) {
            case "usuario":
                switch ($url[1]) {
                    case 'add':
                    case 'update':
                        $dadosUser = json_decode(file_get_contents('php://input')); //tranformar JSON do body em Objetos
                        $userController = new usuarioController;
                        $user = new Usuario;
                        $user->popo($dadosUser);
                        if ($user->id != null) {
                            $result = $userController->update($user);
                        } else {
                            $result = $userController->add($user);
                        }
                        break;
                    default:
                        throw new Exception();
                        break;
                }
                break;

            default:
                throw new Exception();
                break;
        }

        http_response_code(200);
        //echo "Entra de um POST";
        echo json_encode(array("result" => $result));
    }
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(array("result" => "Pagina não encontrada!"));
}
