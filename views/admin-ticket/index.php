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

<?php //echo Html::beginForm(\yii\helpers\Url::to(['dishes-bom/index']),'get',['role' => 'form','class'=>'form-horizontal'])?>
<!--<div class="form-group">-->
<!--    <div class="row">-->
<!--        <label class="col-sm-2 control-label" for="searchName">申请人</label>-->
<!--        <div class="col-xs-4">-->
<!--            <input type="text" class="form-control" name="searchName" id="searchName" value="--><?php //echo empty($searchName)?'':$searchName;?><!--">-->
<!--        </div>-->
<!--        <label class="col-sm-2 control-label" for="searchCategoryId">选择分类</label>-->
<!--        <div class="col-xs-4">-->
<!--            --><?php //echo Html::dropDownList('searchCategoryId',$searchCategoryId,$categoryList,['class'=>'form-control','prompt'=>'选择分类'])?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group">-->
<!--    <div class="row">-->
<!--        <label class="col-sm-2 control-label" for="searchCategoryId">选择厨师</label>-->
<!--        <div class="col-xs-4">-->
<!--            --><?php //echo Html::dropDownList('cookerId',$cookerId,$cookerList,['class'=>'form-control','prompt'=>'选择厨师'])?>
<!--        </div>-->
<!---->
<!--        <label class="col-sm-2 control-label" for="searchStatus">选择状态</label>-->
<!--        <div class="col-xs-4">-->
<!--            --><?php //echo Html::dropDownList('status',$status,$statusList,['class'=>'form-control','prompt'=>'选择状态'])?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group">-->
<!--    <div class="row">-->
<!--        <label class="col-sm-2 control-label" for="searchCategoryId">是否标准</label>-->
<!--        <div class="col-xs-4">-->
<!--            --><?php //echo Html::dropDownList('isStandard',$isStandard,$standardList,['class'=>'form-control','prompt'=>'选择'])?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="row show-grid">-->
<!--    <div class="col-md-4">-->
<!--        --><?php
//        echo Html::submitButton('搜索', ['class' => 'btn btn-info col-sm-4']);
//        echo Html::endForm();
//        ?>
<!--    </div>-->
<!---->
<!--    <div class="col-md-4">-->
<!--        --><?php
//        echo Html::a('新建',['dishes-bom/update'],['class'=>'btn btn-default col-sm-4']);
//        ?>
<!--    </div>-->
<!---->
<!--    <div class="col-md-4">-->
<!--        --><?php
//        echo Html::a('导出',['dishes-bom/export','searchName'=>$searchName,'searchCategoryId'=>$searchCategoryId,'cookerId'=>$cookerId],['class'=>'btn btn-default col-sm-4']);
//        ?>
<!--    </div>-->
<!--</div>-->

<?php
echo Html::a('导出',['admin-ticket/export'],['class'=>'btn btn-default col-sm-4']);
?>
<hr>

<?php if(isset($list)):?>
    <?php echo GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            [
                'attribute' => '#',
                'value' => function($data) {
                    return $data->id;
                }
            ],
            [
                'attribute' => '用户Id',
                'value' => function($data) {
                    return $data->user_id;
                }
            ],
            [
                'attribute' => '抬头',
                'value' => function($data) {
                    return $data->ticket_title;
                }
            ],
            [
                'attribute' => '识别号',
                'value' => function($data) {
                    return $data->ticket_code;
                }
            ],
            [
                'attribute' => '接受方式',
                'value' => function($data) {
                    return $data->receive_type;
                }
            ],
            [
                'attribute' => '快递地址',
                'value' => function($data) {
                    return $data->address;
                }
            ],
            [
                'attribute' => '收件人',
                'value' => function($data){
                    return $data->addressee;
                }
            ],
            [
                'attribute' => '收件人手机',
                'value' => function($data){
                    return $data->addressee_mobile;
                }
            ],
            [
                'attribute' => '打款凭证',
                'value' => function($data){
                    return $data->amount_bill;
                }
            ],
            [
                'attribute' => '服务费凭证',
                'value' => function($data){
                    return $data->service_bill;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{confirm}',
                'headerOptions' => ['width' => '160'],
                'buttons' => [
                    'confirm' => function($url,$model,$key) {
                        if($model->status == 0) {
                            return Html::a('<i class="fa fa-ban"></i> 确认',
                                ['admin-ticket/ajax-confirm','id'=>$key],['data'=>['confirm' =>'是否确认']]);
                        }
                    },
//                    'select' => function($url,$model,$key) {
//                        return Html::a('<i class="fa fa-ban"></i> 编辑',
//                            ['admin-apply/update','id'=>$key]);
//                    },
                ],
            ],
        ],
    ]);?>
<?php endif;?>



<!--<!-- Modal -->-->
<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
<!--                <h4 class="modal-title" id="myModalLabel">选择菜品</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                --><?php //echo Html::beginForm('','post',['role' => 'form','id'=>'modalForm'])?>
<!--                <div class="form-group">-->
<!--                    <label for="name">菜品名称</label>-->
<!--                    <input type="text" class="form-control" name="name" id="name">-->
<!--                    <input type="hidden"  name="sourceBomId" id="sourceBomId">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="categoryId">分类</label>-->
<!--                    --><?php //echo Html::dropDownList('categoryId',null,$categoryList,['prompt'=>'全部'])?>
<!--                </div>-->
<!--                <input type="button" onclick="getBomData()" value="提交" / >-->
<!--                --><?php //echo Html::endForm();?>
<!--                <div id="respone">-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<!-- Modal-->-->

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
    //    })
</script>
