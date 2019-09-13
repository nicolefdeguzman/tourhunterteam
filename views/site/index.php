<?php

use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Test Task';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Tour Hunter Team</h1>
        <p class="lead">This a test task.</p>
    </div>                       
    <div class="body-content">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username',
                'balance',
                [
                    'visible'   => Yii::$app->user->isGuest ? false : true,
                    'class'     => 'yii\grid\ActionColumn',
                    'header'    => 'Action',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center'],
                    'template' => '{transfer}',
                    'buttons'=>[
                        'transfer' => function ($url, $model) {
                            return Yii::$app->user->getId() == $model->id ? '<span class="btn btn-block btn-xs btn-info"><i class="glyphicon glyphicon-user"></i> MY ACCOUNT</span>' : (Html::a('<i class="glyphicon glyphicon-transfer"></i> TRANSFER', ['transfer','receiver_id' => $model->id], ['class' => 'btn btn-xs btn-success btn-block'])) ;
                        },
                    ], 
                    'contentOptions'=>['style'=>'width:85px;'],
                ],
            ],
        ]); ?>
    </div>
</div>
