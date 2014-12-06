<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'caption',
            'link',
            'icon',
            'description',
            [
                'attribute' => 'varActive',
                'value' => 'activeText',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php 
        $menu = \app\models\Menu::find()->where('parentid is null')->all();
        $index = 0;
        echo '<table id="tree">';
        foreach($menu as $data){
            $index++;
            echo '<tr data-level="'.$index.'">';
            echo '<td>' . $data->caption . '</td>';
            echo '<td>' . $data->link . '</td>';
            echo '<td>' . $data->icon . '</td>';
            echo '<td>' . $data->description . '</td>';
            echo '<td>' . $data->active . '</td>';
            echo '</tr>';

            $child = \app\models\Menu::find()->where('parentid = :parent', ['parent'=>$data->menuid])->all();
            $cindex = 0;
            foreach($child as $data1){
                $cindex++;
                echo '<tr data-level="'.$cindex.'">';
                echo '<td>' . $data1->caption . '</td>';
                echo '<td>' . $data1->link . '</td>';
                echo '<td>' . $data1->icon . '</td>';
                echo '<td>' . $data1->description . '</td>';
                echo '<td>' . $data1->active . '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    ?>

    <table id="table1" class="controller">
        <tr data-level="header" class="header"><td></td><td>Column 1</td><td>Column 2</td><td>Column 3</td></tr>
        <tr data-level="1" id="level_1_a"><td>Level 1 A</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="2" id="level_2_a"><td>Level 2 A</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="3" id="level_3_a"><td>Level 3 A</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_a"><td>Level 4 A</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_b"><td>Level 4 B</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="3" id="level_3_b"><td>Level 3 B</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_c"><td>Level 4 C</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_d"><td>Level 4 D</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_e"><td>Level 4 E</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_f"><td>Level 4 F</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_g"><td>Level 4 G</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>  
        <tr data-level="1" id="level_1_b"><td>Level 1 B</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="2" id="level_2_b"><td>Level 2 B</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="3" id="level_3_c"><td>Level 3 C</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_h"><td>Level 4 H</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_i"><td>Level 4 I</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_j"><td>Level 4 J</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="3" id="level_3_d"><td>Level 3 D</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_k"><td>Level 4 K</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_l"><td>Level 4 L</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
        <tr data-level="4" id="level_4_m"><td>Level 4 M</td><td class="data">2</td><td class="data">2</td><td class="data">2</td></tr>
    </table> 


</div>
<?php
    $this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jquery.tabelizer/jquery-ui-1.10.4.custom.min.js", [\yii\web\View::POS_HEAD]);
    $this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/jquery.tabelizer/jquery.tabelizer.js", [\yii\web\View::POS_HEAD]);
?>
<script>
    $(document).ready(function(){
        var table1 = $('#table1').tabelize({
            fullRowClickable : true, 
        });
    });
</script>

<link href="<?php echo yii\helpers\BaseUrl::base(); ?>/plugin/jquery.tabelizer/tabelizer.min.css" media="all" rel="stylesheet" type="text/css" />

