<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */

// $this->title = 'Matcha';
$this->title = 'Chat';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= ListView::widget([
    'dataProvider' => $dataProvider,

    'itemView' => '_chatlist',
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'user-chat',
    ],

    'emptyText' => 'You have no chats yet ;( Wait for smb to like you back',
    'emptyTextOptions' => [
        'tag' => 'p'
    ],

    'summary' => '{count} shown of {totalCount} total',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'list-summary'
    ],

]);
?>