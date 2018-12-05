<?php

namespace app\models;

use Yii;
use yii\base\Model;

class GenerosForm extends Model
{
    /**
     * Nombre del género.
     * @var string
     */
    public $genero;

    public function rules()
    {
        return [
            [['genero'], 'required'],
            [['genero'], 'string', 'max' => 255],
            [['genero'], 'trim'],
            [['genero'], function ($attribute, $params, $validator) {
                $fila = Yii::$app->db
                    ->createCommand('SELECT id
                                       FROM generos
                                      WHERE genero = :genero', [':genero' => $this->$attribute])
                    ->queryOne();
                if (!empty($fila) && $fila['id'] != Yii::$app->request->get('id')) {
                    $this->addError($attribute, 'Ese género ya existe');
                }
            }],
        ];
    }
}
