<?php
use yii\widgets\ListView;

/* @var $this yii\web\View */
// $this->title = 'Matcha';
?>

<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl ?>/matchaJS/like.js"></script>

<?= ListView::widget([
    'dataProvider' => $dataProvider,

    'itemView' => '_userlist',
    'viewParams' => ['likes' => $likes],
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

<div>Notifications<span class="badge">123</span></div>
