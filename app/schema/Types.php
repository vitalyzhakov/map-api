<?php 

namespace app\schema;

class Types extends \GraphQL\Type\Definition\ObjectType
{
    private static $query;

    private static $point;
    private static $polygon;
    private static $route;

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function point()
    {
        return self::$point ?: (self::$point = new PointType());
    }   

    public static function polygon()
    {
        return self::$polygon ?: (self::$polygon = new PolygonType());
    }
    
    public static function route()
    {
        return self::$route ?: (self::$route = new RouteType());
    }

}