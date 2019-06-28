<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->registerCssFile("@web/css/bootstrap-tokenfield.min.css");
$this->registerCssFile("@web/css/jquery-ui.css");
//$this->registerJsFile("@web/js/jquery-ui.min.js",['position'=>\yii\web\View::POS_BEGIN]);
//$this->registerJsFile("@web/js/bootstrap-tokenfield.js",['position'=>\yii\web\View::POS_BEGIN]);

?>

<div class="row show-grid">
    <?php echo Html::beginForm(Url::to(['admin-apply/do-update']),'post',['id'=>'updateForm','role' => 'form','class'=>'form-horizontal','enctype'=>'multipart/form-data'])?>
    <input type="hidden" name="id" value="<?php echo $model->id;?>">
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

    <div class="row show-grid">
        <label class="col-sm-2 control-label" for="standard">营业执照</label>
        <div class="col-sm-10">
            <input type="file" id="" name="imageFile" value=""/>
        </div>
    </div>
    <hr>

    <div class="row show-gird">
        <div class="col-xs-4">
            <?php
            echo Html::button('更新', ['class' => 'btn btn-default','onclick' => 'checkSubmit()']);
            ?>
        </div>
    </div>
    <?php
    echo Html::endForm();
    ?>
</div>
<script type="application/javascript">

    var checkSubmit = function() {
        $('#updateForm').submit();

    };
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