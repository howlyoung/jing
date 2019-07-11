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
    <?php echo Html::beginForm(Url::to(['admin-apply/do-update']),'post',['id'=>'updateForm','role' => 'form','class'=>'form-horizontal','enctype'=>'multipart/form-data'])?>
    <input type="hidden" name="id" id="applyId" value="<?php echo $model->id;?>">
    <input type="hidden" name="access_id" id="accessId" value="<?php echo $access->id;?>">
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">姓名</label>
        <div class="col-xs-4">
            <input  class="form-control" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> name="access_name" value="<?php echo empty($access)?'':$access->name;?>" " />
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">手机号</label>
        <div class="col-xs-4">
            <input  class="form-control" name="access_mobile" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> value="<?php echo empty($access)?'':$access->mobile;?>" " />
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">客户类型</label>
        <div class="col-xs-4" >
            <?php
            $attr = ['class'=>'form-control','prompt'=>'选择类型'];
            if(!$showApplyFlag) {
                $attr['disabled'] = 'true';
            }
            echo Html::dropDownList('access_type',(empty($access)?null:$access->user_type),$accessTypeList,$attr)?>
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">需求描述</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3"  cols="20" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> name="access_desc" ><?php echo empty($access)?'':$access->user_demand_desc;?></textarea>
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">解决方案</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> name="access_solution" ><?php echo empty($access)?'':$access->solution;?></textarea>
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">供需关系</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> name="access_relation" ><?php echo empty($access)?'':$access->relation;?></textarea>
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">客户业务</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> name="access_business" ><?php echo empty($access)?'':$access->user_business;?></textarea>
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">推广人</label>
        <div class="col-xs-4">
            <input  class="form-control" name="access_referrer" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> value="<?php echo empty($access)?'':$access->referrer;?>"  />
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">推广渠道</label>
        <div class="col-xs-4">
            <input  class="form-control" name="access_channel" <?php echo ($showApplyFlag)?'':"disabled='true'" ?> value="<?php echo empty($access)?'':$access->marker_channel;?>"  />
        </div>
    </div>




    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">个体户名称</label>
        <div class="col-xs-4">
            <input name="personName" class="form-control" value="<?php echo empty($model)?'':$model->person_name;?>" id="dishesName" />
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">发票内容</label>
        <div class="col-xs-4">
            <input name="ticketContent" class="form-control" value="<?php echo empty($model)?'':$model->ticket_content;?>" id="dishesName" />
        </div>
    </div>
    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="parent">发票类型</label>
        <div class="col-xs-4">
            <?php echo Html::dropDownList('type',(empty($model)?null:$model->ticket_type),$typeList,['class'=>'form-control','prompt'=>'选择分类'])?>
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">银行卡号</label>
        <div class="col-xs-4">
            <input name="bankCard" class="form-control" value="<?php echo empty($model)?'':$model->bank_card;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="dishesName">开户行</label>
        <div class="col-xs-4">
            <input name="bankCode" class="form-control" value="<?php echo empty($model)?'':$model->bank_code;?>" id="dishesName" />
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">经营行业类别</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" name="busType" id="sellPoint"><?php echo empty($model)?'':$model->bus_type;?></textarea>
        </div>
    </div>

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">经营范围</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" cols="20" name="busRange" id="link"><?php echo empty($model)?'':$model->bus_range;?></textarea>
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

<!--    <div class="row show-grid">-->
<!--        <label class="col-sm-2 control-label" for="standard">营业执照</label>-->
<!--        <div class="col-sm-10">-->
<!--            <input type="file" id="" name="imageFile" value=""/>-->
<!--        </div>-->
<!--    </div>-->
<!--    <hr>-->

    <div class="row show-gird">
        <div class="col-xs-4">
            <?php
            echo Html::button('更新', ['class' => 'btn btn-default','onclick' => 'checkSubmit()']);
            ?>
        </div>
        <?php if($showPassportFlag):?>
        <div class="col-xs-4">
            <?php
            echo Html::button('营业执照已办理', ['class' => 'btn btn-default','onclick' => 'passport('. $model->id .')']);
            ?>
        </div>
        <?php endif;?>
        <?php if($showApplyFlag):?>
        <div class="col-xs-4">
            <?php
            echo Html::button('初审通过', ['class' => 'btn btn-default','onclick' => 'apply()']);
            ?>
        </div>
        <?php endif;?>
    </div>
    <?php
    echo Html::endForm();
    ?>
</div>
<script type="application/javascript">
    $('.zoomify').zoomify();

    var checkSubmit = function() {
        $('#updateForm').submit();

    };

    var apply = function() {
        var form = $('#updateForm');
        var input = $("<input type='hidden' name='apply' value='1' />");
        form.append(input);
        form.submit();
    }

    var passport = function(id) {
        window.location.href = '<?php echo Url::to(['admin-apply/ajax-confirm'])?>' + '&id=' + id;
    }
//    var checkImgType = function() {
//        var type = $('#selectImageType').val();
//        if(type=='micro_shop') {
//            $('#imageTypeFlag').val(0);
//        } else {
//            $('#imageTypeFlag').val(1);
//        }
//    };
//
//    var checkSubmit = function() {
//        var flag = $('#submitFlag').val();
//        var imgFlag = $('#imageTypeFlag').val();
//
////        if(flag==0 && imgFlag==0) {
////            alert('微店图片宽度不符合');
////            return false;
////        } else {
//        $('#updateForm').submit();
////        }
//    };
//
//
//    var mix = function() {
//        var table = $('<table></table>');
//        table.attr('class','table table-bordered');
//        var t;
//        var p = $(this);
//        var code = p.attr('data-code');
//        var f = $('#num-'+code).val();
//        var s = p.attr('data-count');
//        var e = parseInt(s)+parseInt(f);
//        for(var i=s;i<e;i++) {
//            t = $('<tr><td class="col-xs-4"><input class="form-control" name="'+code+'['+i+'][name]" value=""/></td><td class="col-xs-2"><input class="form-control"  name="'+code+'['+i+'][count]" value=""/></td><td class="col-xs-1"><input class="form-control" name="'+code+'['+i+'][unit]" value="克"/></td><td class="col-xs-4"><textarea class="form-control" name="'+code+'['+i+'][desc]" ></textarea></td><input type="hidden" name="'+code+'['+i+'][id]" value="0"/></tr>');
//            table.append(t);
//        }
//        p.attr('data-count',e);
//        $($(this).parent().parent()).append(table);
//    };
//
//    $('#test-main').on('click',mix);
//    $('#test-fix').on('click',mix);
//    $('#test-dressing').on('click',mix);
//    $('#test-modelling').on('click',mix);
//
//
//    var mixSubmit = function() {
//        $('#mix-submit').submit();
//    };
//
//    var delMix = function() {
//        var checks = $("input:checkbox[name='del_mix']:checked");
//        var form = $('<form></form>');
//        form.attr('action','?r=dishes-bom/del-mix');
//        form.attr('method','post');
//        for(var i=0;i<checks.length;i++) {
//            var id = $(checks[i]).val();
//            var input = $('<input type="hidden" name="mixId['+ i +']" value="'+ id +'" />');
//            form.append(input);
//        }
//        var input1 = $('<input type="hidden" name="did" value="<?php //echo empty($model)?0:$model->dishes_bom_id?>//" />');
//        form.append(input1);
//        form.css('display','none');
////        console.log(form);
//        $(document.body).append(form);
//        form.submit();
//    };
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
