<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Resultados;
use yii\widgets\Pjax;
use yii\web\JsExpression;
$this->title="Ideas en acci�n";
/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */

?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php if($equipo->etapa==1 || $equipo->etapa==2){?>
<?= \app\widgets\proyecto\ProyectoPrimeraEntregaWidget::widget(); ?>
<?php //= \app\widgets\proyecto\ProyectoPrimeraEntregaWidget::widget(); ?>
<?php }?>

<?php if($equipo->etapa==2){?>
<?= \app\widgets\proyecto\ProyectoSegundaEntregaWidget::widget(); ?>
<?php }?>

<script>
    
</script>