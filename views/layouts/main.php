<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Creates',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Application', 'url' => ['#'], 'items'=>[
                        
                        [
                            'label'=>'<i class="fa fa-list"></i> Partner Types', 
                            'url'=>['/partner-type/index']],
                        [
                            'label'=>'<i class="fa fa-flag"></i> Countries', 
                            'url'=>['/country/index']],

'<li class="divider"></li>',
                        [
                            'label'=>'<i class="fa fa-building-o"></i> Units', 
                            'url'=>['/unit/index']],
                        [
                            'label'=>'<i class="fa fa-list"></i> Product Types', 
                            'url'=>['/product-type/index']],
                        [
                            'label'=>'<i class="fa fa-tag"></i> Project Status', 
                            'url'=>['/status/index']],

'<li class="divider"></li>',
                        [
                            'label'=>'<i class="fa fa-list"></i> Mind Units', 
                            'url'=>['/mind-unit/index']],
                        [
                            'label'=>'<i class="fa fa-calculator"></i> Project Rates', 
                            'url'=>['/project-rate/index']],
                        [
                            'label'=>'<i class="fa fa-list"></i> Consultant Posititions', 
                            'url'=>['/consultant-position/index']],

'<li class="divider"></li>',
                        [
                            'label'=>'<i class="fa fa-list"></i> Faculties', 
                            'url'=>['/faculty/index']],
                        [
                            'label'=>'<i class="fa fa-list"></i> Departments', 
                            'url'=>['/department/index']],
                        
'<li class="divider"></li>',
                        [
                            'label'=>'<i class="fa fa-bank"></i> Banks', 
                            'url'=>['/bank/index']],
                        [
                            'label'=>'<i class="fa fa-phone"></i> Phone Types', 
                            'url'=>['/phone-type/index']],

'<li class="divider"></li>',
                        [
                            'label'=>'<i class="fa fa-list"></i> Consultant Categories', 
                            'url'=>['/category/index']],
                    ]],
                    ['label' => 'User Management', 'url' => ['#'], 'items'=>[
                        [
                            'label'=>'<i class="fa fa-list"></i> Menus', 
                            'url'=>['/menu/index']],
                        
                        [
                            'label'=>'<i class="fa fa-group"></i> Groups', 
                            'url'=>['/group/index']],

                        [
                            'label'=>'<i class="fa fa-user"></i> Users', 
                            'url'=>['/user/index']],
                    ]],
                    ['label' => 'Project', 'url' => ['#'], 'items'=>[

                    ]],
                ],
                'encodeLabels' => false
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<style>
    .fa {
        text-align: center;
        width:15px
    }
</style>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?=$this->registerCssFile(yii\helpers\BaseUrl::base()."/plugin/font-awesome/css/font-awesome.min.css", [\yii\web\View::POS_HEAD]);?>
