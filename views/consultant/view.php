<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Consultants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.inside td{
    border-top:none !important;
    border-left:none !important;
}
.inside th{
    border-top:none !important;
    border-left:none !important;
}
.inside th:last-child{
    border-right:none !important;
}
.inside td:last-child{
    border-right:none !important;
}
.inside tr:last-child td{
    border-bottom:none !important;
}
</style>
<div class="consultant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->consultantid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->consultantid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th><?= $model->getAttributeLabel('lectureid') ?></th>  <td><?= $model->lectureid ?></td></tr>
            <tr><th><?= $model->getAttributeLabel('employeeid') ?></th> <td><?= $model->employeeid ?></td></tr>
            <tr><th><?= $model->getAttributeLabel('name') ?></th>       <td><?= $model->name ?></td></tr>
            <tr><th><?= $model->getAttributeLabel('residentid') ?></th> <td><?= $model->residentid ?></td></tr>
            <tr><th><?= $model->getAttributeLabel('npwp') ?></th> <td><?= $model->npwp ?></td></tr>
            <tr><th><?= $model->getAttributeLabel('categoryid') ?></th> <td><?= $model->category->category ?></td></tr>

            <tr><th>Consultant Phones</th><td style="padding: 0px;">
                <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>Phone Type</th>
                        <th>Phone</th>
                    </tr>
                <?php 
                    foreach($model->consultantphones as $phone){
                        echo '<tr>';
                        echo '<td>'.$phone->phonetype->name.'</td>';
                        echo '<td>'.$phone->phone.'</td>';
                        echo '</tr>';
                    }
                ?>
                </table>
            </td></tr>

            <tr><th>Consultant Emails</th><td style="padding: 0px;">
                <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>Email</th>
                    </tr>
                <?php 
                    foreach($model->consultantemails as $email){
                        echo '<tr>';
                        echo '<td>'.$email->email.'</td>';
                        echo '</tr>';
                    }
                ?>
                </table>
            </td></tr>

            <tr><th>Consultant Banks</th><td style="padding: 0px;">
                <table class="table table-bordered table-striped inside" style="border: none;margin-bottom:0px">
                    <tr>
                        <th>Bank</th>
                        <th>Branch</th>
                        <th>Account</th>
                        <th>Active</th>
                    </tr>
                <?php 
                    foreach($model->consultantbanks as $bank){
                        echo '<tr>';
                        echo '<td>'.$bank->bank->name.'</td>';
                        echo '<td>'.$bank->branch.'</td>';
                        echo '<td>'.$bank->account.'</td>';
                        echo '<td>'.$bank->activeText.'</td>';
                        echo '</tr>';
                    }
                ?>
                </table>
            </td></tr>

        </tbody>
    </table>

</div>
