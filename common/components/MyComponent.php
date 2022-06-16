<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 03/02/18
 * Time: 20:37
 */

namespace common\components;


use yii\base\Component;
use common\models\Statistic;
class MyComponent extends Component
{
    const EVENT_TRIGGER = "event_trigger";
    public function actionRecord()
    {
        $param = \Yii::$app->request;
        $stats = new Statistic();
        $stats->access_time = date('Y-m-d H:i:s');
        $stats->user_ip = $param->userIP;
        $stats->user_host = $param->hostInfo;
        $stats->path_info = $param->pathInfo;
        $stats->query_string = $param->queryString;
        //var_dump($stats->user_host); die();
        $stats->save();
    }
}