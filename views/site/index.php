<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Project;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
$this->title = 'Project Management System - Creates';
?>
<style>
    .widget-process-div{
        padding-top:5px;
        padding-bottom:5px;
        clear:both;
        font-weight:bold;
    }
    .panel-body{
        padding:10px;
    }
    .panel-heading, .panel-heading-select2, .panel-footer{
        background-color:#222222 !important;
        color:white !important;
        border-color:#4A4A4A !important;
        text-align:center;
        font-weight:bold;
        
    }
    .panel-heading-select2, .panel-footer{
        padding:3px 5px;
    }
    .panel-footer{
        font-size:12px;
        text-align:left;
    }
    .panel-default{
        border-color: #222222 !important;
    }
    .widget-financial-div{
        font-weight:bold;
        padding-top:5px;
        padding-bottom:25px;
        clear:both;
    }
    .widget-deliverable-div{
        padding-top:5px;
        padding-bottom:5px;
        clear:both;
    }
    .widget-process-div.ok, .widget-process-div.ok a{
        color:#2E9401;
    }
    .widget-process-div.no a{
        color:#C01300;
    }
    .widget-deliverable-div{
        font-weight:bold;
    }
    .widget-deliverable-div a{
        color:default;
        cursor:default;
    }
    .panel-deliverable-detail div{
        padding:2px;
    }
    .widget-process-div.no{
        color:#C01300;
    }
    .view-deliverable:hover{
        color:#7E7E7E;
    }
    #widget-process-footer{
        font-weight:500;
        font-style:italic;
    }
    .info{
        font-size:12px;
        font-style:italic;
    }
    .page-header{
        margin-top:0px;
    }
    .badge.blue{
        background-color:#2449A8;
    }
    .badge.red{
        background-color:#C01300;
    }
    @media screen and (max-width: 1024px){
        .widget-financial-div{
            font-weight:bold;
            padding-top:5px;
            padding-bottom:5px;
            clear:both;
        }
    }
</style>
<div class="page-header">
        <h1><i class="fa fa-desktop" style="width:auto"></i> Project Management System <small>Binus Creates</small></h1>
</div>
<div class="row">
   <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading-select2">
                <?php 

        $user = \app\models\User::find()->where(['userid' => Yii::$app->user->identity->userid])->one();
        $data = [];
        $data += ArrayHelper::map(Project::find()
            ->select(['ps_project.projectid', "concat(ps_project.code, ' - ', ps_project.name) as descr"])
            ->innerJoin("ps_projectpic", "ps_project.projectid = ps_projectpic.projectid")
            ->innerJoin("ps_status", "ps_project.statusid = ps_status.statusid and ps_status.name not like '%cancel%'")
            ->where(['in', 'ps_project.unitid', $user->accessUnit])
            ->andWhere('ps_projectpic.userid = :1', [':1' => $user->userid])
            ->asArray()->all(), 'projectid', 'descr'); 
                
                    echo Select2::widget([
                        'name' => 'projectid', 
                        'data' => $data,
                        'id' => 'widget-process-project'
                    ]);
                ?>
            </div>
            <div class="panel-body">
                <div>
                    <div class="widget-process-div row">
                    <div class="col-md-7">
                        <b>Initiation Date: </b><span id="widget-process-initiation"></span>
                    </div>
                    <div class="col-md-5">
                        <b>Status: </b><span id="widget-process-status"></span>
                    </div>
                    </div>
                    <div style="height:auto; border-bottom:1px solid #ccc; margin-bottom:3px;"></div>
                    <div class="widget-process-div no" id="widget-process-proposal">
                         <i class="fa fa-times-circle"></i> Proposal
                    </div>
                    <div class="widget-process-div no" id="widget-process-costingapproval">
                        <i class="fa fa-times-circle"></i> Costing Approval
                    </div>
                    <div class="widget-process-div no" id="widget-process-businessassurance">
                        <i class="fa fa-times-circle"></i> Business Assurance
                    </div>
                    <div class="widget-process-div no" id="widget-process-extagreement">
                        <i class="fa fa-times-circle"></i> External Agreement
                    </div>
                    <div class="widget-process-div no" id="widget-process-intagreement">
                        <i class="fa fa-times-circle"></i> Internal Agreement
                    </div>
                    <div class="widget-process-div no" id="widget-process-finalization">
                        <i class="fa fa-times-circle"></i> Finalization
                    </div>
                    <div class="widget-process-div no" id="widget-process-done">
                        <i class="fa fa-times-circle"></i> Done
                    </div>
                </div>
            </div>
            <div class="panel-footer">Last updated by: 
                <span id="widget-process-footer"></span></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-line-chart"></i> Financial Achivement
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="widget-financial-div">
                        <div class="col-md-4"><i class="fa fa-ellipsis-v"></i> Revenue</div>
                        <div class="col-md-6" style="margin-left:20px" id="widget-financial-revenue"></div>
                    </div>
                    <div class="widget-financial-div">
                        <div class="col-md-4"><i class="fa fa-ellipsis-v"></i> Cash In</div>
                        <div class="col-md-6" style="margin-left:20px" id="widget-financial-cashin"></div>
                    </div>
                    <div class="widget-financial-div">
                        <div class="col-md-4"><i class="fa fa-ellipsis-v"></i> Margin</div>
                        <div class="col-md-6" style="margin-left:20px" id="widget-financial-margin"></div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
            
            </div>
        </div>
   </div>

   <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-edit"></i> Deliverable & Payment
            </div>
            <div class="panel-body">
                <div class="widget-deliverable-div" id="widget-deliverable-payment">
                </div>
            </div>
            <div class="panel-footer">
            
            </div>
        </div>
   </div>

</div>
<script>
if ($('#widget-process-project').val() != ""){
    loadProcess($('#widget-process-project').val());
}
$('#widget-process-project').change(function(e){
    var projectid = e.val;
    loadProcess(projectid);
    
});

function loadProcess(projectid){
    var _url = "<?= yii\helpers\Url::toRoute('site/project-process') ?>?projectid="+projectid;
    $.ajax({
        url: _url,
        dataType: 'json',
        success:function(response){
            if (response != null && response != ""){
                $('#widget-process-status').html(response.status);
                $('#widget-process-initiation').html(response.initiationdate);
                
                if (response.proposal != ""){
                    $('#widget-process-proposal')
                    .html('<a href="<?= yii\helpers\Url::toRoute('proposal/index') ?>?projectid='+response.projectid+'"><i class="fa fa-check-circle"></i> Proposal <span class="info">'+response.proposal+'</span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-proposal')
                    .html('<a href="<?= yii\helpers\Url::toRoute('proposal/index') ?>?projectid='+response.projectid+'"><i class="fa fa-times-circle"></i> Proposal</a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.costingapproval != ""){
                    $('#widget-process-costingapproval')
                    .html('<a href="<?= yii\helpers\Url::toRoute('costing-approval/index') ?>?projectid='+response.projectid+'"><i class="fa fa-check-circle"></i> Costing Approval <span class="info">'+response.costingapproval+'</span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-costingapproval')
                    .html('<a href="<?= yii\helpers\Url::toRoute('costing-approval/index') ?>?projectid='+response.projectid+'"><i class="fa fa-times-circle"></i> Costing Approval</a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.businessassurance != ""){
                    $('#widget-process-businessassurance')
                    .html('<a href="<?= yii\helpers\Url::toRoute('business-assurance/index') ?>?projectid='+response.projectid+'"><i class="fa fa-check-circle"></i> Business Assurance <span class="info">'+response.businessassurance+'</span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-businessassurance')
                    .html('<a href="<?= yii\helpers\Url::toRoute('business-assurance/index') ?>?projectid='+response.projectid+'"><i class="fa fa-times-circle"></i> Business Assurance</a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.extagreement != ""){
                    $('#widget-process-extagreement')
                    .html('<a href="<?= yii\helpers\Url::toRoute('ext-agreement/index') ?>?projectid='+response.projectid+'"><i class="fa fa-check-circle"></i> External Agreement <span class="info">'+response.extagreement+'</span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-extagreement')
                    .html('<a href="<?= yii\helpers\Url::toRoute('ext-agreement/index') ?>?projectid='+response.projectid+'"><i class="fa fa-times-circle"></i> External Agreement</a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.intagreement != ""){
                    $('#widget-process-intagreement')
                    .html('<a href="<?= yii\helpers\Url::toRoute('int-agreement/index') ?>?ExtAgreementSearch%5Bproject%5D='+response.project+'"><i class="fa fa-check-circle"></i> Internal Agreement <span class="info">'+response.intagreement+'</span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-intagreement')
                    .html('<a href="<?= yii\helpers\Url::toRoute('int-agreement/index') ?>?ExtAgreementSearch%5Bproject%5D='+response.project+'"><i class="fa fa-times-circle"></i> Internal Agreement</a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.finalization_acc != ""){
                    $('#widget-process-finalization')
                    .html('<a href="<?= yii\helpers\Url::toRoute('ext-agreement-payment/index') ?>?projectid='+response.projectid+'"><i class="fa fa-check-circle"></i> Finalization <span class="info">'+response.finalization+'</span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-finalization')
                    .html('<a href="<?= yii\helpers\Url::toRoute('ext-agreement-payment/index') ?>?projectid='+response.projectid+'"><i class="fa fa-times-circle"></i> Finalization <span class="info">'+response.finalization+'</span></a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.done != ""){
                    $('#widget-process-done')
                    .html('<a href="<?= yii\helpers\Url::toRoute('sharing-value/view') ?>?projectid='+response.projectid+'"><i class="fa fa-check-circle"></i> Done <span class="info"></span></a>')
                    .attr('class', 'widget-process-div ok');
                }else{
                    $('#widget-process-done')
                    .html('<a href="<?= yii\helpers\Url::toRoute('sharing-value/view') ?>?projectid='+response.projectid+'"><i class="fa fa-times-circle"></i> Done</a>')
                    .attr('class', 'widget-process-div no');
                }

                if (response.log != ""){
                    $('#widget-process-footer').html(response.log);
                }else{
                    $('#widget-process-footer').html('');
                }

            }else{
                $('#widget-process-status').html("");
                $('#widget-process-initiation').html("");

                $('#widget-process-proposal')
                .html('<i class="fa fa-times-circle"></i> Proposal')
                .attr('class', 'widget-process-div no');

                $('#widget-process-costingapproval')
                .html('<i class="fa fa-times-circle"></i> Costing Approval')
                .attr('class', 'widget-process-div no');

                $('#widget-process-businessassurance')
                .html('<i class="fa fa-times-circle"></i> Business Assurance')
                .attr('class', 'widget-process-div no');

                $('#widget-process-extagreement')
                .html('<i class="fa fa-times-circle"></i> External Agreement')
                .attr('class', 'widget-process-div no');

                $('#widget-process-intagreement')
                .html('<i class="fa fa-times-circle"></i> Internal Agreement')
                .attr('class', 'widget-process-div no');

                $('#widget-process-footer').html('');

            }
        }
    });
}

function loadFinancial(){
    var _url = "<?= yii\helpers\Url::toRoute('site/project-achivement') ?>";
    $.ajax({
        url: _url,
        dataType: 'json',
        success:function(response){
            if (response != null && response != ""){
                $('#widget-financial-cashin').html(response.cashin);
                $('#widget-financial-margin').html(response.margin);
                $('#widget-financial-revenue').html(response.revenue);
            }else{
                $('#widget-financial-cashin').html(0);
                $('#widget-financial-margin').html(0);
                $('#widget-financial-revenue').html(0);
            }
        }
    });
}
loadFinancial();

function loadDeliverableProcess(){
    var _url = "<?= yii\helpers\Url::toRoute('site/project-deliverable-payment') ?>";
    $.ajax({
        url: _url,
        dataType: 'json',
        success:function(response){
            if (response != null && response != ""){
                response.forEach(function(entry) {
                    //console.log(entry);

                    if (entry.deliverable != null && entry.deliverable != ""){
                        entry.deliverable.forEach(function(deliverentry) {
                            var text = '<div class="widget-deliverable-div"><i title="Click to view detail" class="fa fa-location-arrow view-deliverable"></i> <a href="'+deliverentry.action+'">'
                                +entry.project
                        +' # ' +deliverentry.process
                        +' <span class="badge '+(deliverentry.timespan.indexOf("-")>-1?'blue':'red')+'">'+deliverentry.timespan.replace("+", "").replace("-", "")+ '</span></a>'
                        +'<div style="margin-left:20px; font-size:13px; color:rgb(121, 121, 121)" class="panel-deliverable-detail">'
                        +'<div><div class="col-md-2"><i class="fa fa-caret-right"></i> Duedate</div> <div class="col-md-10">'+deliverentry.deadline+'</div>'
                        +'<div><div class="col-md-2"><i class="fa fa-caret-right"></i> Description</div> <div class="col-md-10">'+deliverentry.descr+'</div></div>'
                        +'</div>'
                                +'</div>';
                            $("#widget-deliverable-payment").append(text);
                            $("#widget-deliverable-payment .crow").last().animate({
                                opacity : 1, 
                                left: "+50", 
                                height: "toggle"
                            });
                        });
                    }                    
                });
            }
            $('.panel-deliverable-detail').hide();
            $('.view-deliverable').click(function(e){
                if ($(this).closest('.widget-deliverable-div').find('.panel-deliverable-detail').css('display') == "none"){
                    $(this).closest('.widget-deliverable-div').find('.panel-deliverable-detail').slideDown("1000");
                }else{
                    $(this).closest('.widget-deliverable-div').find('.panel-deliverable-detail').slideUp("1000");
                }
            });
        }
    });
}
loadDeliverableProcess();
</script>