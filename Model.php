<?php

class Model
{

    public function __construct()
    {
    }

    // TABLE USER

    //AUTHENTIFICATION DU COMPTE
    public function authUser($handle, $data)
    {
        try {
            $request = $handle->prepare('SELECT * FROM user 
                                        WHERE mail = ? 
                                        AND disable_account = ?');
            $request->execute(array($data->data->email, '0'));
            $user = $request->fetch();

            if (password_verify($data->data->password, $user['password'])) {

                $response = (object) [
                    'requestSql' => true,
                    'data' => $user
                ];

                return $response;
            } else {
                $response = (object) [
                    'requestSql' => false,
                    'data' => 'wrong identifiers'
                ];

                return $response;
            }
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }

    public function getListUser($handle)
    {
        try {
            $request = $handle->prepare('SELECT `id`, `name`, `mail`, `access`, `creation_date` 
                                        FROM user 
                                        WHERE disable_account = ?
                                        ORDER BY access DESC');
            $request->execute(array('0'));
            $data = $request->fetchAll();

            $response = (object) [
                'requestSql' => true,
                'data' => $data
            ];

            return $response;
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }

    public function createUser($handle, $data)
    {
        try {
            $hashed_password = password_hash($data->data->password, PASSWORD_DEFAULT);
            $request = $handle->prepare('INSERT INTO user 
                                        (name, mail, access, password)
                                        VALUES (?, ?, ?, ?)');
            $request->execute(array($data->data->name, $data->data->email, $data->data->access, $hashed_password));
            $lastId = $handle->lastInsertId();

            $response = (object) [
                'requestSql' => true,
                'data' => 'user created',
                'accountId' => $lastId
            ];

            return $response;
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }

    public function disableUser($handle, $data)
    {
        try {
            $request = $handle->prepare('UPDATE user 
                                        SET disable_account = ? 
                                        WHERE id = ?');
            $request->execute(array('1', $data->data->id));

            $response = (object) [
                'requestSql' => true,
                'data' => 'account disabled'
            ];

            return $response;
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }

    public function updateUser($handle, $data)
    {
        try {
            $request = $handle->prepare('UPDATE user 
                                        SET access = ? 
                                        WHERE id = ?');
            $request->execute(array($data->data->access, $data->data->id));

            $response = (object) [
                'requestSql' => true,
                'data' => 'user updated'
            ];

            return $response;
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }


    // TABLE USER_TRACKING_ORDER_URL
    public function getListTracking($handle)
    {
        try {
            $request = $handle->prepare('SELECT * FROM user_tracking_order_url
                                        ORDER BY order_id DESC');
            $request->execute();
            $data = $request->fetchAll();

            $response = (object) [
                'requestSql' => true,
                'data' => $data,
            ];

            return $response;
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }

    //AJOUTER UN NUMERO DE SUIVI
    public function createTrackingOrder($handle, $data)
    {
        try {
            $request = $handle->prepare('INSERT INTO user_tracking_order_url 
                                        (user_id, order_id, tracking_url, tracking_number)
                                        VALUES (?, ?, ?, ?)');
            $request->execute(array($data->data->user_id, $data->data->order_id, $data->data->tracking_url, $data->data->tracking_number));

            $response = (object) [
                'requestSql' => true,
                'data' => 'tracking created',
            ];

            return $response;
        } catch (Exception $e) {

            $response = (object) [
                'requestSql' => false,
                'data' => null
            ];

            return $response;
        };
    }
}
