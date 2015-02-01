<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IntAgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Internal Agreements';
$this->params['breadcrumbs'][] = ['label' => 'Internal Agreement: Select Project', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="int-agreement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h6><em style="color:red">*</em> If there is more than one file, please upload as zip/rar file.</h6>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php
        $extagreement = \app\models\ExtAgreement::findOne(Yii::$app->request->get('extagreementid'));
        if (!(strpos(strtolower($extagreement->project->status->name), 'cancel') !== false)){
            echo Html::a('Create Internal Agreement', ['create', 'extagreementid' => Yii::$app->request->get('extagreementid')], ['class' => 'btn btn-success']);
        }
    ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'extagreement',
                'value' => 'extagreement.description'
            ],
            [
                'attribute' => 'consultant',
                'value' => 'consultant.name'
            ],
            [
                'attribute' => 'department',
                'value' => 'department.name'
            ],
            'description',
            'startdate',
            'enddate',
            [
                'attribute' => 'filename',
                'value'=>'urlFile',
                'format' => 'html'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model, $key){                    
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', \yii\helpers\Url::toRoute(['int-agreement/view','extagreementid'=>$model->extagreementid, 'id'=>$model->intagreementid],false), [
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function($url, $model, $key){                    
                        $extagreement = \app\models\ExtAgreement::findOne(Yii::$app->request->get('extagreementid'));
                        if (!(strpos(strtolower($extagreement->project->status->name), 'cancel') !== false)){
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', \yii\helpers\Url::toRoute(['int-agreement/update','extagreementid'=>$model->extagreementid, 'id'=>$model->intagreementid],false), [
                                'title' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]);
                        }
                    },
                    'delete' => function($url, $model, $key){                    
                        $extagreement = \app\models\ExtAgreement::findOne(Yii::$app->request->get('extagreementid'));
                        if (!(strpos(strtolower($extagreement->project->status->name), 'cancel') !== false)){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', \yii\helpers\Url::toRoute(['int-agreement/delete','extagreementid'=>$model->extagreementid, 'id'=>$model->intagreementid],false), [
                                'title' => Yii::t('yii', 'Delete'),
                                'data-pjax' => '0',
                            ]);
                        }
                    },
                ]
            ],
        ],
    ]); ?>

</div>
<?php
$this->registerJs('
    $(".download").attr("download", "");
');
?>