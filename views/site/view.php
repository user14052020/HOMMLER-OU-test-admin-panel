<?php
use yii\widgets\DetailView;

echo DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'image:image',
	    'sku',
	    'name',
	    'count',
	    'type'
	],
])

?>