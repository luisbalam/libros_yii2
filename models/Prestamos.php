<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestamos".
 *
 * @property int $Id_prestamo
 * @property int $Id_libro
 * @property int $Codigo_usuario
 * @property string $FechaPrestamo
 * @property string $FechaDevolucion
 *
 * @property Usuarios $codigoUsuario
 * @property Libros $libro
 */
class Prestamos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestamos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id_libro', 'Codigo_usuario', 'FechaPrestamo', 'FechaDevolucion'], 'required'],
            [['Id_libro', 'Codigo_usuario'], 'integer'],
            [['FechaPrestamo', 'FechaDevolucion'], 'safe'],
            [['Id_libro'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::className(), 'targetAttribute' => ['Id_libro' => 'id']],
            [['Codigo_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['Codigo_usuario' => 'Codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id_prestamo' => 'Id Prestamo',
            'Id_libro' => 'Id Libro',
            'Codigo_usuario' => 'Codigo Usuario',
            'FechaPrestamo' => 'Fecha Prestamo',
            'FechaDevolucion' => 'Fecha Devolucion',
        ];
    }

    /**
     * Gets query for [[CodigoUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['Codigo' => 'Codigo_usuario']);
    }

    /**
     * Gets query for [[Libro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::className(), ['id' => 'Id_libro']);
    }
}
