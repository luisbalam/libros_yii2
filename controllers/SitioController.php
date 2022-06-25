<?php
    namespace app\controllers;

    use Yii;
    use yii\filters\AccessController;
    use yii\web\Controller;
    use app\models\FormularioForm; //es el formulario o modelo que se creo en models.

    class SitioController extends Controller 
    {
        public function actionInicio(){ //todo método que se crea y pueda controlar inicia con la palabra action

            $model=new FormularioForm; //aqui se instancia el formulario.

            if ( $model->load(Yii::$app->request->post()) && $model->validate() ){ //si hay un envio y se ha validado segun el modelo
                $valorRespuesta= ("El resultado es: ".($model->valora+$model->valorb)); // se genera una cadena con el resultado de la suma de los 2 valores ingresados por el usuario
                return $this->render('inicio', [ 'mensaje'=>$valorRespuesta, 'model'=>$model]); //permite mostrar el resultado a través de la vista.
            }

            return $this->render('inicio', ['mensaje'=>"", 'model'=>$model]); //inicio se refiere a la vista inicio y modelo se refiere al modelo
        }
    }
?>