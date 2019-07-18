<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->registerCssFile("@web/css/bootstrap-tokenfield.min.css");
$this->registerCssFile("@web/css/jquery-ui.css");
$this->registerCssFile("@web/css/zoomify.min.css");
$this->registerCssFile("@web/css/site.css");
$this->registerJsFile("@web/js/jquery.min.js",['position'=>\yii\web\View::POS_BEGIN]);
$this->registerJsFile("@web/js/zoomify.min.js",['position'=>\yii\web\View::POS_BEGIN]);

?>

<div class="row show-grid">
    <?php echo Html::beginForm(Url::to(['admin-ticket/do-update']),'post',['id'=>'updateForm','role' => 'form','class'=>'form-horizontal','enctype'=>'multipart/form-data'])?>
    <input type="hidden" name="id" id="ticketId" value="<?php echo $model->id;?>">

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">个体户名称</label>
        <div class="col-xs-4">
            <input name="personName" class="form-control" value="<?php echo empty($model)?'':$model->person_name;?>" />
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">抬头</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" name="ticketTitle" id="sellPoint"><?php echo empty($model)?'':$model->ticket_title;?></textarea>
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="parent">发票类型</label>
        <div class="col-xs-4">
            <?php echo Html::dropDownList('type',(empty($model)?null:$model->receive_type),$typeList,['class'=>'form-control','prompt'=>'选择类型'])?>
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">识别号</label>
        <div class="col-xs-4">
            <input name="ticketCode" class="form-control" value="<?php echo empty($model)?'':$model->ticket_code;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">发票内容</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" name="ticketContent" id="sellPoint"><?php echo empty($model)?'':$model->ticket_content;?></textarea>
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">快递地址</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" name="address" id="sellPoint"><?php echo empty($model)?'':$model->address;?></textarea>
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">收件人</label>
        <div class="col-xs-4">
            <input name="addressee" class="form-control" value="<?php echo empty($model)?'':$model->addressee;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">收件人手机</label>
        <div class="col-xs-4">
            <input name="addresseeMobile" class="form-control" value="<?php echo empty($model)?'':$model->addressee_mobile;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">开户行</label>
        <div class="col-xs-4">
            <input name="bankCode" class="form-control" value="<?php echo empty($model)?'':$model->bankCode;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">银行账号</label>
        <div class="col-xs-4">
            <input name="bankCard" class="form-control" value="<?php echo empty($model)?'':$model->bank_card;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">公司电话</label>
        <div class="col-xs-4">
            <input name="companyTel" class="form-control" value="<?php echo empty($model)?'':$model->company_tel;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">开票地址</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" name="companyAddress" id="sellPoint"><?php echo empty($model)?'':$model->company_address;?></textarea>
        </div>
    </div>

    <?php foreach($imageKey as $type=>$typeName):?>
        <div class="row show-grid">
            <label class="col-sm-2 control-label" for="images"><?php echo $typeName;?></label>
            <div class="col-sm-10">
                <?php
                echo \kartik\file\FileInput::widget([
//                'model' => new \app\models\Upload(),
                    'name' => $type.'[]',
                    'options' => ['multiple' => true],
                    'pluginOptions' => [
                        'previewFileType' => 'image',
                        'initialPreview' => isset($imageList[$type])?$imageList[$type]:[],
                        'initialPreviewConfig' => isset($imageListConfig[$type])?$imageListConfig[$type]:[],
//                'uploadUrl' => yii\helpers\Url::toRoute(['/dishes-bom/async-image']),
//                'uploadExtraData' => [
//                    'dish_id' => $model->dishes_bom_id,
//                ],
//                'minFileCount' => 1,
//                'maxFileCount' => 10,
                        'initialPreviewAsData' => true,
                        'showRemove' => false,
                        'showUpload' => false,
//                'minImageWidth' => 660,
//                'maxImageWidth' => 660,
//                'uploadAsync' => true,
                        'fileActionSettings' => [
                            'showZoom' => true,
                            'showUpload' => true,
                            'showRemove' => true,
                        ],
                    ],
                    'pluginEvents' => [
                        // 上传成功后的回调方法，需要的可查看data后再做具体操作，一般不需要设置
                        "fileloaded" => "function (event, file, previewId, index, reader) {
                    var img = new Image();
                    img.src = reader.result;
                    if(img.width != 660) {
                        $('#submitFlag').val(0);
                    } else {
                        $('#submitFlag').val(1);
                    }
                    console.log(img.width);

        }",
                    ],
                ]);?>
            </div>
        </div>

    <?php endforeach;?>



    <div class="row show-gird">
        <div class="col-xs-4">
            <?php
            echo Html::button('更新', ['class' => 'btn btn-default','onclick' => 'checkSubmit()']);
            ?>
        </div>
        <?php if($model->status == \app\modelex\JingTicketEx::STATUS_WAIT):?>
            <div class="col-xs-4">
                <?php
                echo Html::a('已开票',['admin-ticket/confirm','id'=>$model->id],['class'=>'btn btn-default col-sm-4']);
                ?>
            </div>
        <?php endif;?>
    </div>
    <?php
    echo Html::endForm();
    ?>
</div>
<script type="application/javascript">

    var checkSubmit = function() {
        $('#updateForm').submit();

    };

    var apply = function() {
        var form = $('#updateForm');
        var input = $("<input type='hidden' name='apply' value='1' />");
        form.append(input);
        form.submit();
    }



</script>


<script type="text/javascript">
    //    $('#tokenfield').tokenfield({
    //        autocomplete: {
    //            source: <?php //echo $tagList;?>//,
    //            delay: 100
    //        },
    //        showAutocompleteOnFocus: true
    //    });
</script>
