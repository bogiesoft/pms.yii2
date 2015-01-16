<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->company;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
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
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->customerid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->customerid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th><?= $model->getAttributeLabel('name') ?></th><td>Astra Credit Company</td></tr>
            <tr><th><?= $model->getAttributeLabel('dayofjoin') ?></th><td>01-Sep-2014</td></tr>
            <tr><th><?= $model->getAttributeLabel('npwp') ?></th><td></td></tr>
            <tr><th><?= $model->getAttributeLabel('phone') ?></th><td>(62-21) 6522555</td></tr>
            <tr><th><?= $model->getAttributeLabel('fax') ?></th><td>(62-21) 6522555</td></tr>
            <tr><th><?= $model->getAttributeLabel('address') ?></th><td>Jl. Gaya Motor Raya No. 8</td></tr>
            <tr><th><?= $model->getAttributeLabel('city') ?></th><td>Jakarta</td></tr>
            <tr><th><?= $model->getAttributeLabel('state') ?></th><td>Sunter II - Jakarta Utara</td></tr>
            <tr><th><?= $model->getAttributeLabel('countryid') ?></th><td>Indonesia</td></tr>
            <tr><th><?= $model->getAttributeLabel('patnertypeid') ?></th><td>Corporation</td></tr>
            <tr><th><?= $model->getAttributeLabel('webpage') ?></th><td>http://www.astra.co.id/</td></tr>
            <tr><th>Contact  Person</th><td style='padding: 0px;'><?= $model->getContactPersonWithPhone() ?></td></tr>
        </tbody>
    </table>


</div>
