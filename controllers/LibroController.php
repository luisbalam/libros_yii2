<?php

namespace app\controllers;

use app\models\Libro;
use app\models\LibroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\UploadedFile;

use yii\data\Pagination;
use Da\QrCode\QrCode;

/**
 * LibroController implements the CRUD actions for Libro model.
 */
class LibroController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access'=> [
                'class'=> AccessControl::className(),
                'only'=>['index','view','create','update','delete'], //lo que verá el usuario logueado
                'rules'=> [
                    [
                    'allow'=>true,
                    'roles'=>['@']
                    ]
                ]

            ]
            ,
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Libro models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libro model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Libro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Libro();

        $this->subirFoto($model);


//INICIA TODO LO DE LA GENERACIÓN DEL CODIGO QR
        $urlqr = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; 
        //$urlqr =  http_build_url(); //otra forma de guardar la URL actual en PHP
        //$qrCode = (new QrCode('https://valladolid.tecnm.mx/')) //este es correcto!
        $qrCode = (new QrCode($urlqr))
        ->setSize(250)
        ->setMargin(5);
        //->useForegroundColor(51, 153, 255);

        // now we can display the qrcode in many ways
        // saving the result to a file:

        $qrCode->writeFile(__DIR__ . '/../qr/code'.time().'.png'); // writer defaults to PNG when none is specified

        //Display directly to the browser
        //header('Content-Type: '.$qrCode->getContentType());
        //echo $qrCode->writeString();

//FIN DE LA GENERACON DEL CODIGO QR

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing Libro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->subirFoto($model);

        //if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        //    return $this->redirect(['view', 'id' => $model->id]);
        //}

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Libro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        if(file_exists($model->imagen)){
            unlink($model->imagen);
        }
        
        
        $model->delete();



        return $this->redirect(['index']);
    }

    public function actionLista(){
        $model=Libro::find();
        $paginacion = new Pagination([
            'defaultPageSize'=>6,
            'totalCount'=> $model->count()

        ]);

        $libros=$model->orderBy('titulo')->offset($paginacion->offset)->limit($paginacion->limit)->all();
        return $this->render('lista',['libros'=>$libros,'paginacion'=>$paginacion]);
    }
    /**
     * Finds the Libro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Libro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function subirFoto(Libro $model) {
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
            //if ($model->load(Yii::$app->request->post())) {   
               
                $model->archivo= UploadedFile::getInstance($model, 'archivo');

                if($model->validate()){

                    if($model->archivo){

                        if(file_exists($model->imagen)){
                            unlink($model->imagen);
                        }

                        $rutaArchivo='uploads/'.time()."_".$model->archivo->baseName.".".$model->archivo->extension;
                        if ($model->archivo->saveAs($rutaArchivo)){
                            $model->imagen=$rutaArchivo;
                        }
                    }
                }

                

                $model->archivo->saveAs($rutaArchivo);


                if ($model->save(false)){
                    return $this->redirect(['index']);
                }

                
            //}
            //} 
            //else {
            // model->loadDefaultValues();
            }
        }
    }
}



//respaldo
// public function behaviors2()
//   {
//        return array_merge(
//            'access'=> [
 //               'class'=> AccessControl::className(),
//                'rules'=> [
 //                   [
//                    'allow'=>true,
//                    'roles'=>['@']
 //               ]
 //           ]
 //           parent::behaviors(),
//            [
 //               'verbs' => [
 //                   'class' => VerbFilter::className(),
 //                   'actions' => [
 //                       'delete' => ['POST'],
 //                   ],
//                ],
 //           ]
 //       );
//    }
//