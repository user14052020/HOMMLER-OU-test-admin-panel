<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
use yii\grid\GridView;
use yii\helpers\Html;

echo Html::a("Добавить товар",["add"],['class' => 'btn btn-info']);
?>

<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<?=Html::beginForm(['bulk'],'post');?>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'showFooter'=> true,
    'tableOptions' => ['id' => 'products','class' => 'table table-striped table-bordered'],
    'columns'=>[
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn','footer'=>'<button type="submit" class="btn btn-info">Удалить</button>'],
        'image:image',
        'sku',
        'name',
        'count',
        'type',
        ['class' =>'yii\grid\ActionColumn']
        
    ]
]);

?>





<?= Html::endForm();?> 

<?=Html::dropDownList('action','',[''=>'Скрыть/Показать колонку: ','2'=>'Изображение','3'=>'SKU','4'=>'Название','5'=>'Кол-во на складе','6'=>'Тип товара'],['class'=>'dropdown',])?>
<?=Html::submitButton('Send', ['class' => 'btn btn-info','id'=>'column_toggle']);?>

<?php
 $this->registerJs("
    $(document).ready(function() {
        $('#column_toggle').on('click',function (e) {
            var column = $('.dropdown').val();
            $('#products th:nth-child(' + column + '), #products td:nth-child(' + column + ')').toggle();
        });
    });
 ");
?>
