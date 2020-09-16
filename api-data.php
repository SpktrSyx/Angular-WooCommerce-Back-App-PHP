<?php

use Core\AccessBdd;

header('Access-Control-Allow-Origin: *');
require_once('AccessBdd.php');
require('Model.php');


// ACCESS DB
function accessDb()
{
    $instance = AccessBdd::getInstance();
    return $instance->getHandle();
}

if (file_get_contents("php://input")) {

    $data = json_decode(file_get_contents("php://input"));
    $model = new Model();

    // TABLE USER

    //CONNEXION
    if ($data->requestType === "logUser") {

        echo json_encode($model->authUser(accessDb(), $data));
    }


    if ($data->requestType === "getAllUser") {

        echo json_encode($model->getListUser(accessDb()));
    }


    if ($data->requestType === "createUser") {

        echo json_encode($model->createUser(accessDb(), $data));
    }

    //on ne delete pas un compte mais on le desactive pour garder 
    //les modifications qu'il a apporté comme 
    //l'ajout de de numéro de suivi
    if ($data->requestType === "disableUser") {

        echo json_encode($model->disableUser(accessDb(), $data));
    }

    if ($data->requestType === "updateUser") {

        echo json_encode($model->updateUser(accessDb(), $data));
    }



    // TABLE USER_TRACKING_ORDER_URL
    if ($data->requestType === "getListTracking") {

        echo json_encode($model->getListTracking(accessDb()));
    }

    if ($data->requestType === "createTrackingOrder") {

        echo json_encode($model->createTrackingOrder(accessDb(), $data));
    }
}
