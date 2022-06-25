<?php
    use yii\helpers\Html; 
    use yii\widgets\ActiveForm; //es para mostrar formularios que se hagan a partir de un modelo.
?>

 <?php

    if($mensaje) { // si hay un mensaje que se envió (variable con ese nombre), entonces imprime el valor que tiene mensaje (es un html).
        echo HTML::tag('div',Html::encode($mensaje), ['class'=> 'alert alert-danger']); //el class es de bootstrap. 
    }

 ?>
 

<?php $formulario=ActiveForm::begin(); ?> 

<?= $formulario->field($model, 'valora') ?>

<?= $formulario->field($model, 'valorb') ?>


<div class="form-group">

<?= Html::submitButton('Enviar',['class'=>'btn btn-primary']) ?>

</div>

<?php ActiveForm::end(); ?>
