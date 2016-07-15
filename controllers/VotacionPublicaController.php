<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\VotacionPublica;
Yii::setAlias('video', '@web/video_carga/');
class VotacionPublicaController extends Controller
{
    
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout='votacionpublica';
        $resultados=VotacionPublica::find()
                    ->select('votacion_publica.proyecto_id,proyecto.titulo,proyecto.resumen,institucion.denominacion,equipo.id as equipo_id,video.tipo,video.ruta')
                    ->innerJoin('proyecto','proyecto.id=votacion_publica.proyecto_id')
                    ->innerJoin('equipo','equipo.id=proyecto.equipo_id')
                    ->innerJoin('video','video.proyecto_id=proyecto.id and video.etapa=2')
                    ->innerJoin('usuario','usuario.id=proyecto.user_id')
                    ->innerJoin('estudiante','estudiante.id=usuario.estudiante_id')
                    ->innerJoin('institucion','institucion.id=estudiante.institucion_id')
                    ->where('votacion_publica.region_id=:region_id',[':region_id'=>16])
                    ->all();
        return $this->render('index',['resultados'=>$resultados]);
    }
    
}
