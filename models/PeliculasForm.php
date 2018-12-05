<?php

namespace app\models;

use yii\base\Model;

class PeliculasForm extends Model
{
    /**
     * [Título de la película.
     * @var string.
     */
    public $titulo;

    /**
     * Año de la película.
     * @var int
     */
    public $anyo;

    /**
     * Duración de la película.
     * @var int
     */
    public $duracion;

    /**
     * Sinopsis de la película.
     * @var string
     */
    public $sinopsis;

    /**
     * ID del género al que pertenece.
     * @var int
     */
    public $genero_id;

    public function rules()
    {
        return [
            [['titulo', 'genero_id'], 'required'],
            [['anyo', 'duracion', 'genero_id'], 'number'],
            [['titulo'], 'string', 'max' => 255],
            [['sinopsis'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
                'titulo' => 'Título',
                'anyo' => 'Año',
                'duracion' => 'Duración',
                'genero_id' => 'Género',
        ];
    }
}
