<?php
namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "meter".
 *
 * @property integer 
 * @property double 
 * @property  
 */
class Meter extends \yii\base\Model
{
    
    const ELECTRICITY_TYPE_VALUE_NO = 0;
    const ELECTRICITY_TYPE_VALUE_ONE_PHASE = 1;
    const ELECTRICITY_TYPE_VALUE_TWO_PHASES = 2;
    const ELECTRICITY_TYPE_TITLE_NO = 'Передам в другой раз';
    const ELECTRICITY_TYPE_TITLE_ONE_PHASE = 'Однотарифный (обычный) счётчик';
    const ELECTRICITY_TYPE_TITLE_TWO_PHASES = 'Двухтарифный счётчик (день-ночь)';
    
    /**
     *
     * @var string
     */
    public $fio;
    
    /**
     *
     * @var string
     */
    public $address;


    /**
     *
     * @var double
     */
    public $cold_water;
    
    /**
     *
     * @var double
     */
    public $hot_water;
    
    /**
     *
     * @var double
     */
    public $electricity_status;
    
    /**
     *
     * @var double
     */
    public $electricity_day;

    /**
     * 
     * @var double
     */
    public $electricity_night;

    public static function getElectricityOptions()
    {
        return [
            self::ELECTRICITY_TYPE_VALUE_NO => self::ELECTRICITY_TYPE_TITLE_NO,
            self::ELECTRICITY_TYPE_VALUE_ONE_PHASE => self::ELECTRICITY_TYPE_TITLE_ONE_PHASE,
            self::ELECTRICITY_TYPE_VALUE_TWO_PHASES => self::ELECTRICITY_TYPE_TITLE_TWO_PHASES
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['fio', 'address', 'cold_water', 'electricity_status'], 'required', 'message' => 'Пожалуйста, заполните'],
                [['cold_water', 'hot_water', 'electricity_day', 'electricity_night'], 'number', 'message' => 'Только целое число'],
                [['electricity_status'], 'integer'],
                [['fio', 'address'], 'string', 'length' => [3, 100]],
                ['electricity_day', 'required', 'message' => 'Пожалуйста, заполните', 'when' => function($model) {
                    return in_array($model->electricity_status, [
                        $model::ELECTRICITY_TYPE_VALUE_ONE_PHASE,
                        $model::ELECTRICITY_TYPE_VALUE_TWO_PHASES
                    ]);
                }, 'whenClient' => "function (attribute, value) {
                    var val = parseInt($('#meter-electricity_status input:checked').val());
                        return val === 1 || val === 2;
            }"], [['electricity_night'], 'required', 'message' => 'Пожалуйста, заполните', 'when' => function($model) {
                    return $model->electricity_status === $model::ELECTRICITY_TYPE_VALUE_TWO_PHASES;
                }, 'whenClient' => "function (attribute, value) {
                    var val = parseInt($('#meter-electricity_status input:checked').val());
                        return val === 2;
            }"]
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {

        return Yii::$app->mailer->compose('meter/html', [
                'model' => $this
            ])
            ->setFrom('info@vnytve.ru')
            ->setTo('pribor-rkz@yandex.ru')
            ->setSubject('Показания счётчиков воды и электричества')
            ->send();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wlid' => 'Wlid',
            'fio' => 'Фамилия, имя и отчество',
            'address' => 'Адрес',
            'cold_water' => 'Холодная вода',
            'hot_water' => 'Горячая вода',
            'electricity_status' => 'Счётчик электричества',
            'electricity_day' => 'Электричество день',
            'electricity_night' => 'Электричество ночь',
        ];
    }

    public function attributeHints()
    {
        return [
            'fio' => 'Например, Иванов Иван Иванович',
            'address' => 'Например, г. Нытва, ул. Попова, д. 46, кв. 164'
        ];
    }

    public static function radioFormatter($index, $label, $name, $checked, $value)
    {
        $id = $name . '-' . $index;
        return Html::radio($name, $checked, [
                'value' => $value,
                'label' => $label,
                'id' => $id
        ]);
    }
}
