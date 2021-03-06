<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Libro */

$this->title = 'Dar de alta un Libro';
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
