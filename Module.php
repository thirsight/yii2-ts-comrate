<?php

namespace ts\comrate;

use Yii;

/**
 * @author Haisen <thirsight@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'ts\comrate\controllers';

    public function init()
    {
        parent::init();

        $this->setBasePath('@ts/comrate');

        Yii::$app->i18n->translations['comrate'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@ts/comrate/messages'
        ];
    }
}
