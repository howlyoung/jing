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
    <title><?= Html::encode($this->title)."京师爷" ?></title>
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
        'brandLabel' => '京师爷后台',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],

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
                            'label' => '申请管理',
                            'items' => [
                                ['label' => '申请列表','url'=> \yii\helpers\Url::to(['admin-access/index']),'controller'=>'admin-access','action'=>'index'],
                            ],
                        ],
                        [
                            'label' => '注册管理',
                            'items' => [
                                ['label' => '注册申请列表','url'=> \yii\helpers\Url::to(['admin-apply/index']),'controller'=>'admin-apply','action'=>'index'],
                            ],
                        ],
                        [
                            'label' => '发票管理',
                            'items' => [
                                ['label' => '发票列表','url'=> \yii\helpers\Url::to(['admin-ticket/index']),'controller'=>'admin-ticket','action'=>'index'],
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
        <p class="pull-left">&copy; 京师爷 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
