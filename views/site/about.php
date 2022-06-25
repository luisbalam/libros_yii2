<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Acerca de';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <h2>
        Aplicación diseñada por: MTI. Luis Alberto Balam Mukul
    </h2>

    <code><?//= __FILE__ ?></code>
</div>
