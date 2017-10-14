<?php
use yii\helpers\Html;

$this->title = "Unread notifications";
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="row is-table-row" style="margin-bottom: 10px;">

    <div class="col-sm-12">
        <?php foreach($notifications as $notification): ?>
            <p>
                <?php echo $notification_list[$notification['notification_type']]; ?>
            </p>
        <?php endforeach; ?>
    </div>

</div>

