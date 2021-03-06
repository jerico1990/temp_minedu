<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $user \common\models\LoginForm */
/* @var $title string */
$opciones_objetivos='';
foreach($objetivos as $objetivo){ 
    $opciones_objetivos=$opciones_objetivos.'<option value='.$objetivo->id.'>'.$objetivo->descripcion.'</option>';
}




?>
<script src="<?= \Yii::$app->request->BaseUrl ?>/autoNumeric-master/autoNumeric.js"></script>
<script src="<?= \Yii::$app->request->BaseUrl ?>/jQuery-Plugins-master/numeric/jquery.numeric.js"></script>

    <div class="col-xs-12 col-sm-12 col-md-12">
	<div class="form-group  field-proyecto-plan_presupuestal_objetivo_99 required" style="margin:0px;">
	    <label class="control-label" for="proyecto-plan_presupuestal_objetivo_99">Objetivo</label>
	    <select id="proyecto-plan_presupuestal_objetivo_99" class="form-control" name="Proyecto[planes_presupuestales_objetivos][]" onchange="actividad($(this).val(),99)" >
		<option value>Seleccionar</option>
		<?= $opciones_objetivos ?>
	    </select>
	</div>
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
	<div class="form-group field-proyecto-plan_presupuestal_actividad_99 required" style="margin: 0px;padding: 0px">
	    <label class="control-label" for="registrar-plan_presupuestal_actividad_99">Actividad</label>
	    <select id="proyecto-plan_presupuestal_actividad_99" class="form-control" name="Proyecto[planes_presupuestales_actividades]" onchange="presupuesto($(this).val())" >
		<option value>Seleccionar</option>
	    </select>
	</div>
    </div>
    <div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12">
	    <table class="table table-striped" id="presupuesto" style="display: none">
		<thead>
		    <th width="100px">Recursos</th>
		    <th width="150px">¿Como conseguirlo?</th>
		    <th width="150px">¿A quién podemos pedirselo?</th>
		    <th width="150px">Precio unitario</th>
		    <th width="150px">Cantidad</th>
		    <th width="50px">Total</th>
		    <?= ($disabled=='')?'<th width="10px"></th>':'' ?>
		</thead>
		<tbody id="presupuesto_cuerpo">
		    
		</tbody>
		<tr>
		    <td>Total</td>
		    <td colspan="4" ></td>
		    <td><div  class="total"></div></td>
		    <td></td>
		</tr>
		<tr>
		    <td colspan="5" ></td>
		    <td colspan="2" style="padding: 0px;">
			<?php if($disabled==''){?>
			<div id="btn_presupuesto" class="btn btn-default pull-right" onclick="InsertarPlanPresupuestal()" style="display: none;background: #1f2a69;color: white">Agregar recurso</div>
			<?php } ?>
		    </td>
		</tr>
	    </table>
	    
	</div>
    <div class="clearfix"></div>

<?php
    $eliminarplanpresupuestal= Yii::$app->getUrlManager()->createUrl('actividad/eliminarplanpresupuestal');
    $cargatablapresupuesto= Yii::$app->getUrlManager()->createUrl('plan-presupuestal/cargatablapresupuesto');
?>
<script>
    
    
    var opciones_objetivos="<?= $opciones_objetivos ?>";
    function actividad(value,contador) {
	$.get( '<?= Yii::$app->urlManager->createUrl('plan-presupuestal/actividades?id=') ?>'+value, function( data ) {
	    $( '#proyecto-plan_presupuestal_actividad_'+contador ).html( data );
	});
    }
    
    $("#presupuesto").on('click',' .remCF',function(){
	
	
        var r = confirm("Estas seguro?");
        if (r == true) {
            id=$(this).children().val();
	
	    if (id) {
		$.ajax({
		    url: '<?= $eliminarplanpresupuestal ?>',
		    type: 'GET',
		    async: true,
		    data: {id:id},
		    success: function(data){
			
		    }
		});
		$(this).parent().parent().remove();	
	    }
	    else
	    {
		$(this).parent().parent().remove();
	    }
            
        } 
    });
    
    var plan=0;
    function InsertarPlanPresupuestal() {
	var error='';
	plan=parseInt($("#contador").val());
	var planespresupuestalesrecursosdescripciones=$('input[name=\'Proyecto[planes_presupuestales_recursos_descripciones][]\']').length;
        console.log(planespresupuestalesrecursosdescripciones);
	
	for (var i=0; i<planespresupuestalesrecursosdescripciones; i++) {
	    
	    if($('#proyecto-plan_presupuestal_recurso_descripcion_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna recurso dscripción <br>';
                $('.field-proyecto-plan_presupuestal_recurso_descripcion_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_recurso_descripcion_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_recurso_descripcion_'+i).removeClass('has-error');
            }
	    /*
	    if($('#proyecto-plan_presupuestal_unidad_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna unidad <br>';
                $('.field-proyecto-plan_presupuestal_unidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_unidad_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_unidad_'+i).removeClass('has-error');
            }
	    */
	    if($('#proyecto-plan_presupuestal_dirigido_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna a quien va dirigido <br>';
                $('.field-proyecto-plan_presupuestal_dirigido_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_dirigido_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_dirigido_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-plan_presupuestal_como_conseguirlo_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna como conseguirlo <br>';
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_como_conseguirlo_'+i).removeClass('has-error');
            }
	    
	    /*if($('#proyecto-plan_presupuestal_precio_unitario_'+i).val()==3 &&  $('#proyecto-plan_presupuestal_precio_unitario_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna precio unitario<br>';
                $('.field-proyecto-plan_presupuestal_precio_unitario_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_precio_unitario_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_precio_unitario_'+i).removeClass('has-error');
            }*/
	    
	    if($('#proyecto-plan_presupuestal_cantidad_'+i).val()=='')
            {
                error=error+'ingrese información en la fila #'+(i+1)+' de la columna cantidad <br>';
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).addClass('has-success');
                $('.field-proyecto-plan_presupuestal_cantidad_'+i).removeClass('has-error');
            }
	    
        }
	if (error!='') {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
	    
	    $('#plan_presupuestal_'+plan).html(
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_recurso_descripcion_"+plan+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_recurso_descripcion_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_recursos_descripciones][]' placeholder='Recurso'  />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_como_conseguirlo_"+plan+"' required' style='margin-top: 0px'>"+
						"<select onchange='ComoConseguirlo($(this).val(),"+plan+")' id='proyecto-plan_presupuestal_como_conseguirlo_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_comos_conseguirlos][]'>"+
						    "<option value>seleccionar</option>"+
						    "<option value='1'>Pedir</option>"+
						    "<option value='2'>Crear</option>"+
						    "<option value='3'>Comprar</option>"+
						"</select>"+
					    "</div>"+
					"</td>"+
					
					/*
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_unidad_"+plan+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_unidad_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_unidades][]' placeholder='Unidad'  />"+
					    "</div>"+
					"</td>"+*/
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_dirigido_"+plan+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_dirigido_"+plan+"' class='form-control' name='Proyecto[planes_presupuestales_dirigidos][]' placeholder='Dirigido' />"+
					    "</div>"+
					"</td>"+
					
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_precio_unitario_"+plan+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_precio_unitario1_"+plan+"' onkeypress='Numerico(event)' onfocus='Subtotal11("+plan+",2)'  onfocusout='Subtotal1("+plan+",1)' class='form-control' name='Proyecto[planes_presupuestales_precios_unitarios1][]' placeholder='S/. 0.00'>"+
						"<input type='hidden' id='proyecto-plan_presupuestal_precio_unitario_"+plan+"'  class='form-control numerico' name='Proyecto[planes_presupuestales_precios_unitarios][]' />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_cantidad_"+plan+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_cantidad_"+plan+"' onkeypress='Numerico(event)'   onfocusout='Subtotal2("+plan+",2)' class='form-control' name='Proyecto[planes_presupuestales_cantidades][]' placeholder='Cantidad' >"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_subtotal_"+plan+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_subtotal1_"+plan+"' class='form-control ' name='Proyecto[planes_presupuestales_subtotales1][]' placeholder='S/. 0.00'   disabled>"+
						"<input type='hidden' id='proyecto-plan_presupuestal_subtotal_"+plan+"' class='form-control totales' name='Proyecto[planes_presupuestales_subtotales][]' placeholder='Subtotal' >"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<span class='remCF glyphicon glyphicon-minus-sign'>"+
					    "</span>"+
					"</td>");
	    $('#presupuesto').append('<tr id="plan_presupuestal_'+(plan+1)+'"><input type="hidden" id="contador" value="'+(plan+1)+'" ></tr>');
	    /*$('#proyecto-plan_presupuestal_precio_unitario1_'+plan).autoNumeric("init",{
		aSep: '.',
		aDec: ',', 
		aSign: 'S/. '
	    });*/
	    
	    
	    plan++;
	}
	return true;
    }
    
    
    
    $('.numerico').keypress(function (e) {
		
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
        var reg = /^[0-9\s]+$/;
        te = String.fromCharCode(tecla); // 5
	return reg.test(te); // 6
		
    });		
	
    $('.texto').keypress(function(e) {
	tecla = (document.all) ? e.keyCode : e.which; // 2
	if (tecla==8) return true; // 3
        var reg = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ'_\s]+$/;
        te = String.fromCharCode(tecla); // 5
	return reg.test(te); // 6
    });
    
    function Numerico(evt)
    {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
	  theEvent.returnValue = 'S/.0.00';
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
    }
    
    
    var x=0;
    var y=0;
    
    
    function Subtotal11(id,tipo) {
	
	//if (jQuery.trim($('#proyecto-plan_presupuestal_precio_unitario1_'+id).val())!='') {
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("0.00");
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/."+$('#proyecto-plan_presupuestal_precio_unitario1_'+id).val());
	//}
	//else
	//{
	  //  $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/.0");
	//}
	
	
    }
    
    function Subtotal1(id,tipo) {
	
	var unitario1 = $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val();
	var total=0;
	if (jQuery.trim(unitario1)!='') {
	    if (tipo==1) {
		x=unitario1.replace("S/.", "");
	    }
	    if ($('#proyecto-plan_presupuestal_cantidad_'+id).val()!='') {
		y=$('#proyecto-plan_presupuestal_cantidad_'+id).val();
	    }
	    
	    var subtotal=x*y;
	    $('#proyecto-plan_presupuestal_subtotal_'+id).val(subtotal);
	    $('#proyecto-plan_presupuestal_subtotal1_'+id).val("S/."+subtotal.toFixed(2));
	    $('#proyecto-plan_presupuestal_precio_unitario_'+id).val($('#proyecto-plan_presupuestal_precio_unitario1_'+id).val());
	    
	    $('#presupuesto .totales').each(function(){
		    //console.log($(this).val());
		    total=total+parseInt($(this).val());
	    });
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/."+parseInt(x).toFixed(2));
	    $('.total').html("S/."+total.toFixed(2));	
	}
	else
	{
	    $('.total').html("S/."+total.toFixed(2));	
	}
	
    }
    
    function Subtotal2(id,tipo) {
	var unitario1 = $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val();
	var total=0;
	if (jQuery.trim(unitario1)!='') {
	    if (tipo==2) {
		y=$('#proyecto-plan_presupuestal_cantidad_'+id).val();
	    }
	    
	    if (unitario1.replace("S/.", "")!='') {
		x=unitario1.replace("S/.", "");
	    }
	    var subtotal=x*y;
	    $('#proyecto-plan_presupuestal_subtotal_'+id).val(subtotal);
	    $('#proyecto-plan_presupuestal_subtotal1_'+id).val("S/."+subtotal.toFixed(2));
	    
	    
	    $('#presupuesto .totales').each(function(){
		    //console.log($(this).val());
		    total=total+parseInt($(this).val());
	    });
	    
	    $('.total').html("S/."+total.toFixed(2));	
	}
	else
	{
	    $('.total').html("S/."+total.toFixed(2));
	}
	
    }
    
    function ComoConseguirlo(value,id) {
	var total=0;
	if (value==1 || value==2)
	{
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).val("S/."+total.toFixed(2));
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).prop( "disabled", true );
	    $('#proyecto-plan_presupuestal_precio_unitario_'+id).val(total.toFixed(2));
	    
	    $('#proyecto-plan_presupuestal_subtotal_'+id).val(total.toFixed(2));
	    $('#proyecto-plan_presupuestal_subtotal1_'+id).val("S/."+total.toFixed(2));
	    
	    
	    
	    
	}
	else
	{
	    $('#proyecto-plan_presupuestal_precio_unitario1_'+id).prop( "disabled", false );
	}
	
	
	$('#presupuesto .totales').each(function(){
		//console.log($(this).val());
		total+=parseInt($(this).val());
		//console.log(total);
	});
	//console.log(total);
	$('.total').html("S/."+total.toFixed(2));
    }
    
    
    function presupuesto(valor) {
	
	$.ajax({
	    url: '<?= $cargatablapresupuesto ?>',
	    type: 'GET',
	    async: true,
	    dataType: 'json',
	    data: {valor:valor},
	    success: function(data){
		var tebody="";
		var i=data[0];
		var total=0;
		if (data) {
		    data.splice(0,1);
		    $.each(data, function(i,star) {
			total=total+star.subtotal;
			var select1="";
			var select2="";
			var select3="";
			var disable="";
			$("#proyecto-plan_presupuestal_como_conseguirlo_"+i+" selected").val(star.como_conseguirlo);
			if (star.como_conseguirlo=='1') {
			    select1="selected";
			    disable="disabled";
			}
			if (star.como_conseguirlo=='2') {
			    select2="selected";
			    disable="disabled";
			}
			if (star.como_conseguirlo=='3') {
			    select3="selected";
			    disable="";
			}
			tebody=tebody+"<tr id='plan_presupuestal_"+i+"'>"+
					"<td style='padding: 2px'>"+
					    
					    "<div class='form-group field-proyecto-plan_presupuestal_recurso_descripcion_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_recurso_descripcion_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_recursos_descripciones][]' placeholder='Recurso' value='"+star.recurso_descripcion+"' <?= $disabled?> />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_como_conseguirlo_"+i+"' required' style='margin-top: 0px'>"+
						"<select onchange='ComoConseguirlo($(this).val(),"+i+")' id='proyecto-plan_presupuestal_como_conseguirlo_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_comos_conseguirlos][]' <?= $disabled?>>"+
						    "<option value>seleccionar</option>"+
						    "<option value='1' "+select1+">Pedir</option>"+
						    "<option value='2' "+select2+">Crear</option>"+
						    "<option value='3' "+select3+">Comprar</option>"+
						"</select>"+
					    "</div>"+
					"</td>"+
					/*
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_unidad_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_unidad_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_unidades][]' placeholder='Unidad' value='"+star.unidad+"'  <?= $disabled?>/>"+
					    "</div>"+
					"</td>"+*/
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_dirigido_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_dirigido_"+i+"' class='form-control' name='Proyecto[planes_presupuestales_dirigidos][]' placeholder='Dirigido' value='"+star.dirigido+"'  <?= $disabled?>/>"+
					    "</div>"+
					"</td>"+
					
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_precio_unitario_"+i+"' required' style='margin-top: 0px'>"+
						"<input onkeypress='Numerico(event)' id='proyecto-plan_presupuestal_precio_unitario1_"+i+"' onfocusout='Subtotal1("+i+",1)' class='form-control numerico' name='Proyecto[planes_presupuestales_precios_unitarios1][]' placeholder='Precio unitario' value='S/."+star.precio_unitario.toFixed(2)+"' <?= $disabled?> "+disable+">"+
						"<input type='hidden' id='proyecto-plan_presupuestal_precio_unitario_"+i+"'  class='form-control ' name='Proyecto[planes_presupuestales_precios_unitarios][]' value='"+star.precio_unitario+"' />"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_cantidad_"+i+"' required' style='margin-top: 0px'>"+
						"<input onkeypress='Numerico(event)' id='proyecto-plan_presupuestal_cantidad_"+i+"' onfocusout='Subtotal2("+i+",2)' class='form-control' name='Proyecto[planes_presupuestales_cantidades][]' placeholder='Cantidad' value='"+star.cantidad+"' <?= $disabled?> >"+
					    "</div>"+
					"</td>"+
					"<td style='padding: 2px'>"+
					    "<div class='form-group field-proyecto-plan_presupuestal_subtotal_"+i+"' required' style='margin-top: 0px'>"+
						"<input id='proyecto-plan_presupuestal_subtotal1_"+i+"' class='form-control ' name='Proyecto[planes_presupuestales_subtotales1][]' placeholder='Subtotal' value='S/."+star.subtotal.toFixed(2)+"' disabled>"+
						"<input type='hidden' id='proyecto-plan_presupuestal_subtotal_"+i+"' class='form-control totales' name='Proyecto[planes_presupuestales_subtotales][]' placeholder='Subtotal' value='"+star.subtotal+"'  >"+
					    "</div>"+
					"</td>"+
					<?php if($disabled==''){ ?>
					"<td style='padding: 2px'>"+
					    "<span class='remCF glyphicon glyphicon-minus-sign'>"+
						"<input class='id' type='hidden' name='Proyecto[planes_presupuestal_ids][]' value='"+star.id+"' />"+
						
					    "</span>"+
					"</td>"+
					<?php } ?>
				    "</tr>";			   
		    });
		    tebody=tebody+"<tr id='plan_presupuestal_"+i+"'><input type='hidden' id='contador' value='"+i+"' ></tr>"
		}
		//$("#diskamountUnit").val('$' + total.toFixed(2));
		$('.total').html("S/."+total.toFixed(2));
		$('#presupuesto_cuerpo').html(tebody);
		$('#presupuesto').show();
		$('#btn_presupuesto').show();
		
	    }
	});
    }
</script>
