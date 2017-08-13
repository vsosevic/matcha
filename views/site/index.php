<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

// $this->title = 'Matcha';
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,

    'itemView' => '_userlist',
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'user-card',
    ],

    'emptyText' => 'No matches yet :(',
    'emptyTextOptions' => [
        'tag' => 'p'
    ],

    'summary' => '{count} shown of {totalCount} total',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'list-summary'
    ],


]); ?>



