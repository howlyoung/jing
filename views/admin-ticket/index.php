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

<?php echo Html::beginForm(\yii\helpers\Url::to(['admin-ticket/index']),'get',['role' => 'form','class'=>'form-horizontal'])?>
<div class="form-group">
    <div class="row">
        <label class="col-sm-2 control-label" for="searchName">申请人</label>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="name" id="searchName" value="<?php echo empty($name)?'':$name;?>">
        </div>
        <label class="col-sm-2 control-label" for="searchCategoryId">选择状态</label>
        <div class="col-xs-4">
            <?php echo Html::dropDownList('status',$status,$statusList,['class'=>'form-control','prompt'=>'选择状态'])?>
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
        echo Html::a('导出',['admin-ticket/export','name'=>$name,'status'=>$status],['class'=>'btn btn-default col-sm-4']);
        ?>
    </div>
</div>



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
                'attribute' => '个体户名称',
                'value' => function($data) {
                    return $data->person_name;
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
                'attribute' => '金额',
                'value' => function($data) {
                    return \app\lib\tools\CashUtil::toReadFmt($data->ticket_amount);
                }
            ],
            [
                'attribute' => '接收方式',
                'value' => function($data) {
                    return $data->getMode();
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
                'attribute' => '状态',
                'value' => function($data){
                    return $data->getStatusName();
                }
            ],
//            [
//                'attribute' => '打款凭证',
//                'value' => function($data){
//                    return $data->amount_bill;
//                }
//            ],
//            [
//                'attribute' => '服务费凭证',
//                'value' => function($data){
//                    return $data->service_bill;
//                }
//            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{confirm} {select}',
                'headerOptions' => ['width' => '160'],
                'buttons' => [
                    'confirm' => function($url,$model,$key) {
                        if($model->status == \app\modelex\JingTicketEx::STATUS_WAIT) {
                            return Html::a('<i class="fa fa-ban"></i> 已开票',
                                ['admin-ticket/ajax-confirm','id'=>$key],['data'=>['confirm' =>'是否已开票']]);
                        }
                    },
                    'select' => function($url,$model,$key) {
                        return Html::a('<i class="fa fa-ban"></i> 编辑',
                            ['admin-ticket/update','id'=>$key]);
                    },
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
    //    })
</script>
