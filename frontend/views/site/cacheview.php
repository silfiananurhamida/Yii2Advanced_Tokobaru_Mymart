<?php
	if ($this->beginCache('cachedview')){
		foreach ($models as $model) :
			echo $model->id . " " $model->username . " " .$model->email . "	<br/>";
		endforeach();
		$this->endCache();
		echo "Count", \frontend\models\User::find()->count();
	}
?>