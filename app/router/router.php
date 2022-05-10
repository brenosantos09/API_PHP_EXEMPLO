<?php

//Rotas do Usuario
function routeUser($method, $url, $auth)    
{
    $result = null;
    //Rotas Autenticadas
    switch ($method) {
            //Leituras
        case "GET": {
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

                            case "listnot": {
                                    $userController = new usuarioController;
                                    $result = $userController->getAll(0);
                                }
                                break;
                        }
                        break;
                }
            }
            break;

            //Cadastro
        case "POST": {
                switch ($url[0]) {
                    case "usuario":
                        switch ($url[1]) {
                            case 'add':
                            case 'update':
                                $dadosUser = json_decode(file_get_contents('php://input')); //tranformar JSON do body em Objetos
                                $userController = new usuarioController;
                                $user = new Usuario;
                                $user->popo($dadosUser);
                                if ($user->id != null) { // Se tem id Update se não Add
                                    $result = $userController->update($user);
                                } else {
                                    $result = $userController->add($user);
                                }
                                break;
                            case "upload" && $auth:
                                $userController = new usuarioController;
                                $user = json_decode($auth);
                                $nameFile = uploadfotos(MIDIAS_USER);
                                if ($nameFile) {
                                    $userController->updatePhoto($user->uid, $nameFile);
                                }
                                $result = $nameFile;
                                break;
                        }
                        break;
                }
            }
            break;

            //Alteração
        case "PUT": {
                switch ($url[0]) {
                    case "usuario":
                        switch ($url[1]) {
                            case 'update':
                                $dadosUser = json_decode(file_get_contents('php://input')); //tranformar JSON do body em Objetos
                                $userController = new usuarioController;
                                $user = new Usuario;
                                $user->popo($dadosUser);
                                $result = $userController->update($user);
                                break;
                        }
                        break;
                }
            }
            break;

            //Delete
        case "DELETE": {
                switch ($url[0]) {
                    case "usuario":
                        switch ($url[1]) {
                            case 'delete':
                                if (!isset($url[2])) throw new Exception();
                                $userController = new usuarioController;
                                $result = $userController->delete($url[2]);
                                break;
                        }
                        break;
                }
            }
            break;
    }
    return $result;
}


//Rotas do Produto
function routeProduto($method, $url, $auth)
{
    $result = null;
    //Rotas Autenticadas
    switch ($method) {

            //Leituras
        case "GET": {
                switch ($url[0]) {
                    case "produto":
                        switch ($url[1]) {
                            case "get": {
                                    if (!isset($url[2])) throw new Exception();
                                    $produtoController = new produtoController;
                                    $result = $produtoController->get($url[2]);
                                }
                                break;

                            case "list": {
                                    $produtoController = new produtoController;
                                    $pag = isset($url[2]) && intval($url[2]) ? $url[2] : 1;
                                    $result = $produtoController->getAll(pag: $pag);
                                }
                                break;

                            case "listnot": {
                                    $pag = isset($url[2]) && intval($url[2]) ? $url[2] : 1;
                                    $produtoController = new produtoController;
                                    $result = $produtoController->getAll(ativo: 0, pag: $pag);
                                }
                                break;
                        }
                        break;
                }
            }
            break;

            //Cadastro
        case "POST": {
                switch ($url[0]) {
                    case "produto":
                        switch ($url[1]) {
                            case 'add':
                            case 'update':
                                $dadosProduto = json_decode(file_get_contents('php://input'));
                                $produtoController = new produtoController;
                                $produto = new Produto;
                                $produto->popo($dadosProduto);
                                if ($produto->id != null) {
                                    $result = $produtoController->update($produto);
                                } else {
                                    $result = $produtoController->add($produto);
                                }
                                break;
                            case "upload":
                                $produtoController = new produtoController;
                                $produto = isset($url[2]) ? $url[2] : null;
                                $nameFile = uploadfotos(MIDIAS_PRODUTOS);
                                if ($produto != null) {
                                    if ($nameFile) {
                                        $produtoController->updatePhoto($produto, $nameFile);
                                    }
                                }
                                $result = $nameFile;
                                break;
                        }
                        break;
                }
            }
            break;

            //Alteração
        case "PUT": {
                switch ($url[0]) {
                    case "produto":
                        switch ($url[1]) {
                            case 'update':
                                $dadosProduto = json_decode(file_get_contents('php://input')); //tranformar JSON do body em Objetos
                                $produtoController = new produtoController;
                                $produto = new produto;
                                $produto->popo($dadosProduto);
                                $result = $produtoController->update($produto);
                                break;
                            default:
                                throw new Exception();
                                break;
                        }
                        break;
                }
            }
            break;

            //Delete
        case "DELETE": {
                switch ($url[0]) {
                    case "produto":
                        switch ($url[1]) {
                            case 'delete':
                                if (!isset($url[2])) throw new Exception();
                                $produtoController = new produtoController;
                                $result = $produtoController->delete($url[2]);
                                break;
                        }
                        break;
                }
            }
            break;
    }
    return $result;
}
