<?php

namespace Blok\Utils\Traits;

/**
 * Class modelUtilsTrait
 *
 * Some usefull modelUtilsTrait to use in your model
 *
 * @package Arx\traits
 */
trait HasModelUtilityTrait
{
    use SingletonTrait;

    public static $structure;

    /**
     * Prepare input for query
     *
     * @param array $param
     * @return array
     */
    public static function prepareParams(array $param){

        $fillable = static::getInstance()->getFillables();

        foreach($param as $key => $value){
            if(!in_array($key, $fillable)){
                unset($param[$key]);
            } elseif(!$value){
                unset($param[$key]);
            }
        }

        return $param;
    }

    /**
     * Get fillables columns from model helpers
     *
     * @return array
     */
    public static function getFillables()
    {
        $instance = static::getInstance();

        $fillable = $instance->fillable;

        if($fillable === array('*') || !$fillable){
            $instance->fillable = array_keys($instance->getStructure());
        }

        return $instance->fillable;
    }

    /**
     * Get Rules from Model
     */
    public static function getRules()
    {
        $instance = static::getInstance();

        $structure = $instance->getStructure();

        $rules = $instance->rules;

        if(!$rules){
            $rules = [];

            foreach($structure as $key => $column){
                $rules[$key] = '';
            }
        }

        return $rules;
    }

    /**
     * Get Structure from DB
     *
     * @return \Doctrine\DBAL\Schema\Column[]
     */
    public static function getStructure()
    {
        if(!static::$structure){
            static::$structure = \DB::getDoctrineSchemaManager()->listTableColumns(static::getInstance()->getTable());
        }

        return static::$structure;
    }

}
