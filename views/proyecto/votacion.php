<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;
use app\models\Proyecto;
use app\models\Video;
use app\models\VotacionInterna;
use app\models\ObjetivoEspecifico;
use app\models\Actividad;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\ProyectoSearch */
/* @var $form yii\widgets\ActiveForm */

$votaciones = $model->getProyectoVotacion($searchModel->titulo);

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($votaciones['pages']->pageSize * $_GET['page']) - $votaciones['pages']->pageSize;
    
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="<?= \Yii::$app->request->BaseUrl ?>/css/style_votacion_regional.css" rel="stylesheet">
<?php /*
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Votación regional
</div>
<div class="box_content contenido_seccion_crear_equipo" >
    <?php if (!$votacionesinternasfinalizadasCount || $votacion_publica){ ?>
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
            'action' => ['votacion'],
            'method' => 'get',
        ]); ?>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-proyecto-region_id required">
                <label class="control-label" for="proyecto-region_id">Región</label>
                <select id="proyecto-region_id" class="form-control" name="ProyectoSearch[region_id]" >
                    <option value></option>
                    <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
                        <option value="<?= $departamento->department_id ?>" <?= ($searchModel->region_id==$departamento->department_id)?'selected':'' ?>><?= $departamento->department ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group label-floating field-proyecto-titulo required">
                <label class="control-label" for="proyecto-titulo">Proyecto</label>
                <input type="text" name="ProyectoSearch[titulo]" class="form-control" value="<?= $searchModel->titulo?>">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-raised btn-default pull-right']) ?>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'titulo',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{like}',
                    'buttons' => [
                        'view' => function ($url,$model,$key) {
                            return Html::a('<span class="glyphicon glyphicon-edit" ></span>',['foro/view?id='.$model->foro_id],[]);
                        },//style="color:green"
                        'like' => function ($url,$model,$key) {
                            $votacioninterna=VotacionInterna::find()
                                ->where('proyecto_id=:proyecto_id and user_id=:user_id',
                                        [':proyecto_id'=>$model->id,':user_id'=>\Yii::$app->user->id])
                                ->one();
                            if($votacioninterna)
                            {
                                return Html::a('<span class="glyphicon glyphicon-thumbs-up" style="color:green"></span>',['votacion#'],['onclick'=>'Seleccionar2('.$model->id.',event)']);
                            }
                            else
                            {
                                return Html::a('<span class="glyphicon glyphicon-thumbs-up" ></span>',['votacion#'],['onclick'=>'Seleccionar2('.$model->id.',event)']);
                            }
                        }
                    ],
                ]
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <?php } ?>
    <div class="col-md-6">
        <table class="table">
            <th>Proyecto</th>
            <th>Equipo</th>
            <?php foreach($votacionesinternas as $votacioninterna){ ?>
            <tr>
                <td><?= $votacioninterna->proyecto->titulo ?></td>
                <td><?= $votacioninterna->proyecto->equipo->descripcion_equipo ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php if (!$votacionesinternasfinalizadasCount){?>
        <button type="button" id="btnfinalizarvotacion" class="btn btn-raised btn-default pull-right">Finalizar votación</button>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
</div>
*/ ?>

    <div class="box_head title_content_box">
        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_send_big.png" alt="">VOTACIÓN REGIONAL
    </div>
    <div class="box_content contenido_seccion_votacion">
        <?php $form = ActiveForm::begin([
            'action' => ['votacion'],
            'method' => 'get',
        ]); ?>
        
            <div class="row content_form" style="padding:0;">
                <div class="col-xs-12 col-sm-9 col-md-9">
                    <div class="form-group field-proyecto-region_id required" style="margin: 0px;">
                        <input type="text" class="form-control" name="ProyectoSearch[titulo]">
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-default">Buscar</button>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
        <div class="content_votacion">
            <div class="row">
                <div class="col-md-8">
                    <div class="col_left_options">
                        <?php foreach($votaciones['votaciones'] as $votacion):
                            $floor_number=$floor++; //?????
                        ?>
                        <?php $voto=VotacionInterna::find()->where('user_id=:user_id and proyecto_id=:proyecto_id',
                                                                   [':user_id'=>\Yii::$app->user->id,':proyecto_id'=>$votacion["id"]])->one(); ?>
                        <div class="box_content_option" data-id="<?= $votacion["id"] ?>" data-title="<?= $votacion["titulo"] ?>">
                            <img data-toggle="modal" data-target="#myModal<?= $votacion["id"] ?>" src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_votation_info.jpg" class="icon_votation_info md">
                            <?php if (!$votacionesinternasfinalizadasCount){ ?>
                            <a  href="#" class="btn_votation_item <?= ($voto)?'active':''; ?>">
                                Vote
                            </a>
                            <?php } ?>
                            <h1 class="box_option_title">> TITULO</h1>
                            <p class="box_option_content">
                                <?= $votacion["titulo"] ?>
                            </p>
                            <h1 class="box_option_title">> EQUIPO / IIEE</h1>
                            <p class="box_option_content">
                                <?= $votacion["descripcion_equipo"] ?>
                            </p>
                        </div>
                        
                        <div class="modal fade md" id="myModal<?= $votacion["id"] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                            <div class="popup_mi_busqueda">
                                <div class="popup_content">
                                    <a href="#" class="popup_close">
                                        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_popup.png">
                                    </a>

                                    <div class="popup_content_scroll">
                                        <div class="box_search_border_blue">
                                            <h1 class="h1_box_search">
                                                > TITULO
                                            </h1>
                                            <p class="box_search_content">
                                                <?= $votacion["titulo"] ?>
                                            </p>

                                            <h1 class="h1_box_search">
                                                > SUMILLA / JUSTIFICACIÓN
                                            </h1>
                                            <p class="box_search_content text-justify">
                                                <?= $votacion["resumen"] ?>
                                            </p>

                                            <h1 class="h1_box_search">
                                                > EQUIPO / IIEE
                                            </h1>
                                            <p class="box_search_content">
                                                <?= $votacion["descripcion_equipo"] ?>
                                            </p>

                                            <h1 class="h1_box_search">
                                                > REGIÓN
                                            </h1>
                                            <p class="box_search_content">
                                                <?= $votacion["department"] ?>
                                            </p>

                                            <h1 class="h1_box_search">
                                                > BENEFICIARIOS
                                            </h1>
                                            <p class="box_search_content">
                                                <?= $votacion["beneficiario"] ?>
                                            </p>

                                            <h1 class="h1_box_search">
                                                > OBJETIVO GENERAL
                                            </h1>
                                            <p class="box_search_content">
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div id="mostrar_oe_actividades">
                                                    <div id="oe_1" class='col-xs-12 col-sm-12 col-md-12'>
                                                        <?php $objetivos_especificos=ObjetivoEspecifico::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$votacion["id"]])->all(); ?>
                                                        <?php
                                                        $proyecto= new Proyecto;
                                                        $b=1;
                                                        foreach($objetivos_especificos as $objetivo_especifico)
                                                        {
                                                            if($b==1)
                                                            {
                                                                $proyecto->objetivo_especifico_1_id=$objetivo_especifico->id;
                                                                $proyecto->objetivo_especifico_1=$objetivo_especifico->descripcion;
                                                            }
                                                            if($b==2)
                                                            {
                                                                $proyecto->objetivo_especifico_2_id=$objetivo_especifico->id;
                                                                $proyecto->objetivo_especifico_2=$objetivo_especifico->descripcion;
                                                            }
                                                            if($b==3)
                                                            {
                                                                $proyecto->objetivo_especifico_3_id=$objetivo_especifico->id;
                                                                $proyecto->objetivo_especifico_3=$objetivo_especifico->descripcion;
                                                            }
                                                            $b++;
                                                        }
                                                        $actividades=Actividad::find()
                                                        ->select('objetivo_especifico.id objetivo_especifico_id,actividad.id actividad_id,actividad.descripcion,actividad.resultado_esperado')
                                                        ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                                                        ->where('proyecto_id=:proyecto_id and actividad.estado=1',[':proyecto_id'=>$votacion["id"]])->all();
                                                        
                                                        $acti1=1;
                                                        $acti2=1;
                                                        $acti3=1;
                                                        ?>
                                                        
                                                        
                                                        <?php if($proyecto->objetivo_especifico_1){ ?>
                                                            <ul>
                                                                <li id='oespe'><b>Objetivo N° 1: <?= $proyecto->objetivo_especifico_1 ?></b>   </li>
                                                                <ul>
                                                                    <?php foreach($actividades as $actividad){ ?>
                                                                        <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_1_id){?>
                                                                            <li id='act'>Actividad: <?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_1][]'></li>
                                                                            
                                                                        <?php $acti1 ++; } ?>
                                                                    <?php  } ?>
                                                                </ul>
                                                            </ul>
                                                        <?php } ?>
                                                    </div>
                                                    
                                                    <div id="oe_2" class='col-xs-12 col-sm-12 col-md-12'>
                                                        <?php if($proyecto->objetivo_especifico_2){  ?>
                                                            <ul>
                                                                <li id='oespe'><b>Objetivo N°2: <?= $proyecto->objetivo_especifico_2 ?></b>  </li>
                                                                    
                                                                <ul>
                                                                    <?php foreach($actividades as $actividad){ ?>
                                                                        <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_2_id){?>
                                                                            <li id='act'>Actividad: <?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_2][]'></li>
                                                                            
                                                                        <?php $acti2++;} ?>
                                                                    <?php  } ?>
                                                                </ul>
                                                            </ul>
                                                            <?php $contoe=2; ?>
                                                        <?php } ?>
                                                    </div>
                                                    
                                                    <div id="oe_3" class='col-xs-12 col-sm-12 col-md-12'>
                                                        <?php if($proyecto->objetivo_especifico_3) { ?>
                                                            <ul>
                                                                <li id='oespe'><b>Objetivo N°3: <?= $proyecto->objetivo_especifico_3 ?></b> </li>
                                                                    
                                                                <ul>
                                                                    <?php foreach($actividades as $actividad){ ?>
                                                                        <?php if($actividad->objetivo_especifico_id==$proyecto->objetivo_especifico_3_id){?>
                                                                            <li id='act'>Actividad: <?= $actividad->descripcion ?><input type='hidden' value='<?= $actividad->descripcion ?>' name='Proyecto[actividades_3][]'></li>
                                                                        <?php $acti3++;  } ?>
                                                                    <?php  } ?>
                                                                </ul>
                                                            </ul>
                                                            <?php $contoe=3; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                        
                                            </p>
                                            
                                            <h1 class="h1_box_search">
                                                > PLAN PRESUPUESTAL
                                            </h1>
                                            <p class="box_search_content">
                                                <?= \app\widgets\planpresupuestal\PlanPresupuestalWidget::widget(['proyecto_id'=>$votacion["id"],'disabled'=>true]); ?> 
                                            </p>
                                            
                                            <h1 class="h1_box_search">
                                                > CRONOGRAMA
                                            </h1>
                                            <p class="box_search_content">
                                                <?= \app\widgets\cronograma\CronogramaWidget::widget(['proyecto_id'=>$votacion["id"],'disabled'=>true]); ?> 
                                            </p>
                                            
                                            <h1 class="h1_box_search">
                                                > PRIMER ARCHIVO
                                            </h1>
                                            <p class="box_search_content">
                                                <?php if($votacion["proyecto_archivo"]!=NULL){ ?>
                                                <a href="<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $votacion["proyecto_archivo"] ?>" target="_blank" class=" btn-lateral"><img height=22px src="<?= \Yii::$app->request->BaseUrl ?>/img/pdf.png"> Primera entrega</a> 
                                                <?php } ?>
                                            </p>
                                            
                                            <h1 class="h1_box_search">
                                                > PRIMER VIDEO
                                            </h1>
                                            <?php $video1=Video::find()->where('proyecto_id=:proyecto_id and etapa=1',[':proyecto_id'=>$votacion["id"]])->one(); ?>
                                            <p class="box_search_content">
                                                <?php if($video1){ ?>
                                                <iframe type="text/html" 
                                                    width="320" 
                                                    height="240" 
                                                    src="https://www.youtube.com/embed/<?= substr($video1->ruta,-11) ?>" 
                                                    frameborder="0">
                                                </iframe>
                                                <?php } ?>
                                            </p>
                                            
                                            <h1 class="h1_box_search">
                                                > SEGUNDO ARCHIVO
                                            </h1>
                                            <p class="box_search_content">
                                                <?php if($votacion["proyecto_archivo2"]!=NULL){ ?>
                                                <a href="<?= \Yii::$app->request->BaseUrl ?>/proyectos/<?= $votacion["proyecto_archivo2"] ?>" target="_blank" class=" btn-lateral"><img height=22px src="<?= \Yii::$app->request->BaseUrl ?>/img/pdf.png"> Segunda entrega</a> 
                                                <?php } ?>
                                            </p>
                                            
                                            <h1 class="h1_box_search">
                                                > SEGUNDO VIDEO
                                            </h1>
                                            <?php $video2=Video::find()->where('proyecto_id=:proyecto_id and etapa=2',[':proyecto_id'=>$votacion["id"]])->one(); ?>
                                            <p class="box_search_content">
                                                <?php if($video2){ ?>
                                                <iframe type="text/html" 
                                                    width="320" 
                                                    height="240" 
                                                    src="https://www.youtube.com/embed/<?= substr($video2->ruta,-11) ?>" 
                                                    frameborder="0">
                                                </iframe>
                                                <?php } ?>
                                            </p>
                                            
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>		
                        </div>
                        <?php endforeach; ?>
                        
                    </div>
                </div>
    
                <div class="col-md-4 col_right_options">
                    <div class="title_col">
                        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_heart_small.jpg" alt="">
                        MI SELECCIÓN:
                    </div>
                    
                    <?php if (!$votacionesinternasfinalizadasCount){ ?>
                    <div id="v1" class="box_votation_small vt1" data-id="1" data-option="">
                        <a href="#" class="icon_delete_box">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_small.png">
                        </a>
                        <div class="box_votacion_number">
                            1
                        </div>
                        <div class="box_votacion_content">
                        </div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v2" class="box_votation_small vt2" data-id="2" data-option="">
                        <a href="#" class="icon_delete_box">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_small.png">
                        </a>
                        <div class="box_votacion_number">
                            2
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v3" class="box_votation_small vt3" data-id="3" data-option="">
                        <a href="#" class="icon_delete_box">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_close_small.png">
                        </a>
                        <div class="box_votacion_number">
                            3
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <input type="hidden" id="input_votation_1" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_2" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_3" class="input_votation_option" value="">
                    <?php } else { ?> 
                    <div id="v1" class="box_votation_small vt1" data-id="1" data-option="">
                        <div class="box_votacion_number">
                            1
                        </div>
                        <div class="box_votacion_content">
                        </div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v2" class="box_votation_small vt2" data-id="2" data-option="">
                        <div class="box_votacion_number">
                            2
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <div id="v3" class="box_votation_small vt3" data-id="3" data-option="">
                        <div class="box_votacion_number">
                            3
                        </div>
                        <div class="box_votacion_content"></div>
                        <div class="box_votacion_arrow">
                            <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_arrow_votacion.jpg">
                        </div>
                    </div>
                    
                    <input type="hidden" id="input_votation_1" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_2" class="input_votation_option" value="">
                    <input type="hidden" id="input_votation_3" class="input_votation_option" value="">
                        
                    <?php } ?>
                    <?php if (!$votacionesinternasfinalizadasCount){ ?>
                    <button class="btn btn-default btn-send-votation">CONFIRMAR VOTACIÓN</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php $a=1; ?>
<?php foreach($votaciones['votaciones'] as $votacion): ?>
    <?php $voto=VotacionInterna::find()->where('user_id=:user_id and proyecto_id=:proyecto_id',
                                               [':user_id'=>\Yii::$app->user->id,':proyecto_id'=>$votacion["id"]])->one(); ?>
    
    
    <?php if($voto){ ?>
        <script>
            var p=$('#v'+<?= $a ?>);
            p.addClass('active');
            p.attr("data-option", "<?= $votacion["id"] ?>");
			    
                $(".box_votacion_content", p).html("<?= $votacion["titulo"] ?>");
                $("#input_votation_"+ <?= $a ?>).val("<?= $votacion["id"] ?>");
                
            
        </script>
        <?php $a++; ?>
    <?php } ?>
<?php endforeach; ?>                                     

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>                                                                  

<script src="<?= \Yii::$app->request->BaseUrl ?>/js/app.js" charset="utf-8"></script>
<?php
    $votacion= Yii::$app->getUrlManager()->createUrl('proyecto/votacioninterna');
    $finalizarvotacion= Yii::$app->getUrlManager()->createUrl('proyecto/finalizarvotacioninterna');
?>
<script>
var countvotacion=<?= $votacionesinternasCount ?>;
    
function Seleccionar2(id,event) {
    event.preventDefault();
    $.ajax({
        url: '<?= $votacion ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            
            if (data==1) {
                $.notify({
                    // options
                    message: 'Tu voto ha sido registrado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
            else if (data==2) {
                $.notify({
                    // options
                    message: 'Tu voto se ha deseleccionado' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
            else if (data==3) {
                $.notify({
                    // options
                    message: 'Solo puedes votar por 3 proyectos' 
                },{
                    // settings
                    type: 'danger',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                }); 
            }
        }
    });
}

$('#btnfinalizarvotacion').click(function(event){
    if (countvotacion<3) {
        $.notify({
            // options
            message: 'Debes votar por 3 proyectos' 
        },{
            // settings
            type: 'danger',
            z_index: 1000000,
            placement: {
                    from: 'bottom',
                    align: 'right'
            },
        });
        return false;
    }
    
    
    $.ajax({
        url: '<?= $finalizarvotacion ?>',
        type: 'GET',
        async: true,
        success: function(data){
            if (data==1) {
                $.notify({
                    // options
                    message: 'Ha finalizado el proceso de votación interna' 
                },{
                    // settings
                    type: 'success',
                    z_index: 1000000,
                    placement: {
                            from: 'bottom',
                            align: 'right'
                    },
                });
                setTimeout(function(){
                        window.location.reload(1);
                    }, 2000);
            }
        }
    });
    return true;
    
});
$(document).ready(function(){
    $(document).on('click', '.btn-send-votation', function (e) {
            e.preventDefault();
            var o = $(this);
            var d = o.parent();
            var flag=<?= $regionCount ?>;
            var pasar=0;
            var numOptions = 0;
            
            $(".input_votation_option").each(function(){
                    var obj = $(this);
                    if(obj.val() != "") numOptions++;
            });
            if (flag>=3) {
                if(numOptions == 3){
                    d.addClass("form_send");
                    o.hide();
                    
                    $.ajax({
                        url: 'finalizarvotacioninterna',
                        type: 'GET',
                        async: true,
                        success: function(data){
                            if (data==1) {
                                $.notify({
                                    // options
                                    message: 'Ha finalizado el proceso de votación interna' 
                                },{
                                    // settings
                                    type: 'success',
                                    z_index: 1000000,
                                    placement: {
                                            from: 'bottom',
                                            align: 'right'
                                    },
                                });
                                setTimeout(function(){
                                        window.location.reload(1);
                                    }, 2000);
                            }
                        }
                    });
                }else{
                    $.notify({
                        // options
                        message: 'Debes votar por 3 proyectos' 
                    },{
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                        //alert("Se deben seleccionar 3 opciones para culminar la votación.");
                }   
            }
            else if (flag<3) {
                if(numOptions >= 1){
                    d.addClass("form_send");
                    o.hide();
                    
                    $.ajax({
                        url: 'finalizarvotacioninterna',
                        type: 'GET',
                        async: true,
                        success: function(data){
                            if (data==1) {
                                $.notify({
                                    // options
                                    message: 'Ha finalizado el proceso de votación interna' 
                                },{
                                    // settings
                                    type: 'success',
                                    z_index: 1000000,
                                    placement: {
                                            from: 'bottom',
                                            align: 'right'
                                    },
                                });
                                setTimeout(function(){
                                        window.location.reload(1);
                                    }, 2000);
                            }
                        }
                    });
                }else{
                    $.notify({
                        // options
                        message: 'Debes votar por los menos 1 proyecto' 
                    },{
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                        //alert("Se deben seleccionar 3 opciones para culminar la votación.");
                }
            }
            
            
    });
    
});
</script>