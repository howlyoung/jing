<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\SideNavWidget;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title)."菜品管理系统" ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        .submenu a {
            background: #f5f5f5;
            border-radius: 0;
            padding-left: 20px;
        }

        .submenu a:hover, .submenu a:active,
        .submenu a.active, .submenu a.active:hover, .submenu a.active:active {
            background: #44b5f6;
            border-color: #44b5f6;
            border-radius: 0;
            color: #fff;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $session = yii::$app->session;
    NavBar::begin([
        'brandLabel' => '不二街菜品管理系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
//            ['label' => 'About', 'url' => ['/site/about']],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => '选店', 'url' => ['/site/select-merchant']],
            Yii::$app->user->isGuest ? (
            ['label' => '登录', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '注销 (' . Yii::$app->user->identity->user_name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),

        ],
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php
                echo SideNavWidget::widget([
                    'id' => 'navigation',
                    'items' => [
                        [
                            'label' => '菜品管理',
                            'items' => [
                                ['label' => '分类列表','url'=> \yii\helpers\Url::to(['dishes-category/index']),'controller'=>'dishes-category','action'=>'index'],
                                ['label' => '菜品列表','url'=> \yii\helpers\Url::to(['dishes-bom/index']),'controller'=>'dishes-bom','action'=>'index'],
                            ],
                        ],
                        [
                            'label' => '原料管理',
                            'items' => [
                                ['label' => '分类列表','url'=> \yii\helpers\Url::to(['material-category/index']),'controller'=>'material-category','action'=>'index'],
                                ['label' => '原料列表','url'=> \yii\helpers\Url::to(['material/index']),'controller'=>'material','action'=>'index'],
                            ],
                        ],
                        [
                            'label' => '厨师管理',
                            'items' => [
                                ['label' => '厨师列表','url'=> \yii\helpers\Url::to(['cooker/index']),'controller'=>'cooker','action'=>'index'],
                            ],
                        ],
                        [
                            'label' => '采购管理',
                            'items' => [
                                ['label' => '采购列表','url'=> \yii\helpers\Url::to(['buy/index']),'controller'=>'buy','action'=>'index'],
                            ],
                        ],
                        [
                            'label' => '标签管理',
                            'items' => [
                                ['label' => '标签列表','url'=> \yii\helpers\Url::to(['tag/index']),'controller'=>'tag','action'=>'index'],
                            ],
                        ],
                    ],
                    'view' => $this,
                ]);
                ?>
            </div>

            <div class="col-lg-7">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 不二街 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
