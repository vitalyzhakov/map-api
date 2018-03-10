<?php

namespace app\controllers;

use app\schema\Types;
use GraphQL\GraphQL;
use GraphQL\Schema;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use GraphQL\Error\Debug;

class GraphqlController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    protected function verbs() {
        return [
            'index' => ['POST'],
        ];
    }

    public function actions() {
        return [];
    }

    public function actionIndex() {
        // сразу заложим возможность принимать параметры
        // как через MULTIPART, так и через POST/GET

        $query = \Yii::$app->request->get('query', \Yii::$app->request->post('query'));
        $variables = \Yii::$app->request->get('variables', \Yii::$app->request->post('variables'));
        $operation = \Yii::$app->request->get('operation', \Yii::$app->request->post('operation', null));

        if (empty($query)) {
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variables = isset($input['variables']) ? $input['variables'] : [];
            $operation = isset($input['operation']) ? $input['operation'] : null;
        }

        // библиотека принимает в variables либо null, либо ассоциативный массив
        // на строку будет ругаться

        if (!empty($variables) && !is_array($variables)) {
            try {
                $variables = Json::decode($variables);
            } catch (InvalidParamException $e) {
                $variables = null;
            }
        }

        // создаем схему и подключаем к ней наши корневые типы

        $schema = new Schema([
            'query' => Types::query(),
        ]);


        // огонь!

        $result = GraphQL::executeQuery(
                        $schema, $query, null, null, empty($variables) ? null : $variables, empty($operation) ? null : $operation
        )->toArray(Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        \Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        \Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'X-PINGOTHER, Content-Type');

        return $result;
    }

}
