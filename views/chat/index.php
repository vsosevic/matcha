<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

// $this->title = 'Matcha';
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,

    'itemView' => '_chatlist',
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'user-chat',
    ],

    'emptyText' => 'No chats yet :(',
    'emptyTextOptions' => [
        'tag' => 'p'
    ],

    'summary' => '{count} shown of {totalCount} total',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'list-summary'
    ],


]); ?>



