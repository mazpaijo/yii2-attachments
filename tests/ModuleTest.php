<?php
/**
 * Created by PhpStorm.
 * User: Alimzhan
 * Date: 2/2/2016
 * Time: 9:47 PM
 */

namespace tests;

use nemmo\attachments\Module;
use Yii;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    private $_module;

    protected function setUp()
    {
        $this->_module = Yii::$app->getModule('attachments');
    }

    protected function tearDown()
    {
        Yii::$app->setModule('attachments', $this->_module);
    }

    public function testInitException()
    {
        Yii::$app->setModule('attachments', [
            'class' => Module::className(),
            'storePath' => ''
        ]);
        $this->setExpectedException('Exception', 'Setup {storePath} and {tempPath} in module properties');
        Yii::$app->getModule('attachments');
    }

    public function testInit()
    {
        Yii::$app->language = 'ru';
        /** @var Module $module */
        $module = Yii::$app->getModule('attachments');
        $this->assertEquals([
            'maxFiles' => 3
        ], $module->rules);

        $newRules = [
            'maxFiles' => 10,
            'mimeTypes' => 'image/png',
            'maxSize' => 1024
        ];
        Yii::$app->setModule('attachments', [
            'class' => Module::className(),
            'rules' => $newRules
        ]);
        $module = Yii::$app->getModule('attachments');
        $this->assertEquals($newRules, $module->rules);
    }
}