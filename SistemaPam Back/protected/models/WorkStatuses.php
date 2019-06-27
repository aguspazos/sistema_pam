<?php

class WorkStatuses
{
    public static $STARTED = 1;
    public static $PRINTED = 2;
    public static $WITH_LAMINATE = 3;
    public static $WITH_RUMBLING = 4;
    public static $WITH_UV = 5;
    public static $BOUNDED = 6;
    public static $FINISHED = 7;
    public static $DELIVERED = 8;

    public static $WITH_DETAILS = -77;


    public $id;
    public $name;

    public static function getName($id)
    {
        switch ($id) {
            case self::$STARTED:
            return 'Empezado';
            break;
            case self::$PRINTED:
            return 'Impreso';
            break;
            case self::$WITH_LAMINATE:
                return 'Laminado';
                break;
            case self::$WITH_RUMBLING:
                return 'Troquelado';
                break;
            case self::$WITH_UV:
                return 'UV';

                break;
            case self::$BOUNDED:
                return 'Encuadernado';
                break;
            case self::$FINISHED:
                return 'Terminado';
                break;
            case self::$DELIVERED:
                return 'Enviado';
                break;
        }
        return false;
    }

    public static function getModel($id)
    {
        $model = new WorkStatuses;
        $model->id = $id;
        $model->name = self::getName($id);
        return $model;
    }

    public static function getArray($id)
    {
        $model = array();
        $model['id'] = $id;
        $model['name'] = self::getName($id);
        return $model;
    }

    public static function getAll()
    {
        $modelsArray = array();
        for ($i = 1; $i < 8; $i++)
            $modelsArray[] = self::getModel($i);

        return $modelsArray;
    }

    public static function getAllArray()
    {
        $modelsArray = array();
        for ($i = 1; $i < 9; $i++)
            $modelsArray[] = self::getArray($i);

        return $modelsArray;
    }

    public static function validId($id)
    {
        return in_array($id, array(1, 2, 3, 4,5,6,7,8));
    }
}
