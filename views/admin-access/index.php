<?php
/* @var $this yii\web\View */
?>
<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$cssString = '.GoStyle
    {
         color: #0c5fc4;
         border: 0px none;
         cursor: hand;
         font-family: "宋体";
         font-size: 15px;
    }';
$this->registerCss($cssString);
?>

<?php echo Html::beginForm(\yii\helpers\Url::to(['admin-access/index']),'get',['role' => 'form','class'=>'form-horizontal'])?>
<div class="form-group">
    <div class="row">
        <label class="col-sm-2 control-label" for="searchName">申请人</label>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="searchName" id="searchName" value="<?php echo empty($searchName)?'':$searchName;?>">
        </div>
        <label class="col-sm-2 control-label" for="searchCategoryId">选择状态</label>
        <div class="col-xs-4">
            <?php echo Html::dropDownList('status',$status,$statusList,['class'=>'form-control','prompt'=>'选择状态'])?>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <label class="col-sm-2 control-label" for="searchCategoryId">选择手机</label>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo empty($mobile)?'':$mobile;?>">
        </div>
    </div>
</div>

<div class="row show-grid">
    <div class="col-md-4">
        <?php
        echo Html::submitButton('搜索', ['class' => 'btn btn-info col-sm-4']);
        echo Html::endForm();
        ?>
    </div>

    <div class="col-md-4">
        <?php
        echo Html::a('导出',['admin-access/export','searchName'=>$searchName,'status'=>$status,'mobile'=>$mobile],['class'=>'btn btn-default col-sm-4']);
        ?>
    </div>
</div>

<?php if(isset($list)):?>
    <?php echo GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            'mobile',
            'name',
            [
                'attribute' => '客户类型',
                'value' => function($data) {
                    return ($data->user_type==0)?'个人':'公司';
                }
            ],
            [
                'attribute' => '遇到什么问题',
                'value' => function($data){
                    return $data->user_demand_desc;
                }
            ],
            [
                'attribute' => '如何解决的',
                'value' => function($data){
                    return $data->solution;
                }
            ],
            [
                'attribute' => '与客户之间的关系',
                'value' => function($data){
                    return $data->relation;
                }
            ],
            [
                'attribute' => '主要业务',
                'value' => function($data){
                    return $data->user_business;
                }
            ],
            [
                'attribute' => '状态',
                'value' => function($data){
                    return $data->getStatusName();
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{confirm} {check}',
                'headerOptions' => ['width' => '160'],
                'buttons' => [
//                    'select' => function($url,$model,$key) {
//                        return Html::a('<i class="fa fa-ban"></i> 编辑',
//                            ['dishes-bom/update','bid'=>$key]);
//                    },
                    'confirm' => function($url,$model,$key) {
                        if($model->status == 0) {
                            return Html::a('<i class="fa fa-ban"></i> 审核',
                                ['admin-access/ajax-confirm','id'=>$key],['data'=>['confirm' =>'是否确认']]);
                        }
                    },
                    'check' => function($url,$model,$key) {
                        if($model->status == 1) {
                            return Html::a('<i class="fa fa-ban"></i> 查看',
                                ['admin-access/ajax-confirm','id'=>$key]);
                        }
                    },
//                    'copy' => function($url,$model,$key) {
//                        if($model->checkIsStandard()) {
//                            return Html::a('<i class="fa fa-ban"></i> 复制',
//                                ['dishes-bom/copy','dishesId'=>$key]);
//                        } else {
//                            return Html::a('<i class="fa fa-ban"></i> ');
//                        }
//                    },
                ],
            ],
        ],
    ]);?>
<?php endif;?>

<script type="application/javascript">
    //    var getBomData = function ()
    //    {
    //        var from = $('#modalForm');
    //        $.ajax({
    //            url:"<?php //echo \yii\helpers\Url::to(['dishes/validate-form']);?>//",
    //            type:'post',
    //            data: from.serialize(),
    //            success:function(data) {
    //                $('#respone').html(data);
    //            }
    //        });
    //    }
    //
    //    $('#myModal').on('show.bs.modal', function (event) {
    //        var button = $(event.relatedTarget) // Button that triggered the modal
    //        var recipient = button.data('whatever') // Extract info from data-* attributes
    //
    //        var modal = $(this)
    //        var bomId = modal.find('#sourceBomId');//.val(recipient);
    //
    //        if(bomId.val() != recipient) {
    //            modal.find('#respone').html('');
    //        }
    //        bomId.val(recipient);

    //        modal.find('.modal-body input').val(recipient)
    })
</script>
