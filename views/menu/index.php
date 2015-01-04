<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php

    $menu = new \app\models\Menu();
    $strTree = $menu->getStructureTreeLink();
    $strTree = '<div id="tree"><ul class="ul">' . $strTree;
    $strTree = $strTree . '</ul></div>';
//////////////////////////////////////////////////////////////////////////////////////////
    $items = [
    [
        'label'=>'<i class="fa fa-table"></i> Table View',
        'content'=>
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'caption',
                    'link',
                    'description',
                    [
                        'attribute' => 'varActive',
                        'value' => 'activeText',
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]),
        'active'=>true
    ],
    [
        'label'=>'<i class="fa fa-list-alt"></i> Tree View',
        'content'=>$strTree
        
    ]]
?>

    <?php
        echo TabsX::widget([
            'items'=>$items,
            'position'=>TabsX::POS_ABOVE,
            'encodeLabels'=>false
        ]);
    ?>

</div>

<link href="<?php echo yii\helpers\BaseUrl::base(); ?>/plugin/font-awesome/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css" />

<style>
    .ui-widget-content{
        border: none;
    }
    .ul{
        padding-left:20px !important;
    }
    .daredevel-tree li{
        padding-bottom:3px;
    }
    .daredevel-tree li>ul>li{
        padding-top:3px;
    }
    .daredevel-tree li span.daredevel-tree-anchor{
        margin-top:0px;
    }
    .a {
        color: #337ab7 !important;
        text-decoration: none;
    }
</style>

<?php
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jquery/jquery-1.11.1.min.js", [\yii\web\View::POS_HEAD]);
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jquery-ui/jquery-ui.js", [\yii\web\View::POS_HEAD]);
$this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jtree/jquery.tree.min.js", [\yii\web\View::POS_HEAD]);

$this->registerCssFile(yii\helpers\BaseUrl::base()."/plugin/jquery-ui/jquery-ui.css", [\yii\web\View::POS_HEAD]);
$this->registerCssFile(yii\helpers\BaseUrl::base()."/plugin/jtree/jquery.tree.min.css", [\yii\web\View::POS_HEAD]);
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tree').tree({
            'dnd':false,
        });
    });
</script>