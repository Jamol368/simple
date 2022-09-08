<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Category::find()->all(), 'id', 'title'),
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
                'allowClear' => true
            ],
        ])
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?php if($model->isNewRecord) echo $form->field($model, 'img')->fileInput(['required'=>'required']);
    else echo $form->field($model, 'img')->fileInput();
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
