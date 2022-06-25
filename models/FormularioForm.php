<?php
    namespace app\models;

    use yii\base\Model; //para crear el modelo a partir de una clase existente

    class FormularioForm extends Model // puede extender de Model por lo especificado en la linea 4
    {
        public $valora;
        public $valorb;

        public function rules() //son las reglas para validar el modelo
        {
           return [

              [['valora','valorb'], 'required'], //ambos valores van a ser requeridos (a y b)
              ['valora','number'], ['valorb','number'] //aquí se indica el tipo de datos de cada valor o variable.

           ]; 
        }
    }

?>
