<?php
/**
 * 百度地图类库封装
 */
class Map{
    /**
     * 根据地址来获取经纬度
     * @param $address
     * http://api.map.baidu.com/place/v2/suggestion?query=天安门&region=北京&city_limit=true&output=json&ak=你的ak //GET请求
     * @return array
     */
    public static function getLngLat($address,$region="全国"){
        if(!$address){
            return null;
        }
        $data=[
            'query'=>$address,
            'region'=>$region,
            'output'=>'json',
            'ak'=>config('map.ak')
        ];
        $url=config('map.baidu_map_url').config('map.geocoder').'?'.http_build_query($data);
        //var_dump($url);
        //请求接口参数
        //file_get_contents($url);
        $result=doCurl($url);
        if($result!=''){
            $address=json_decode($result)->result[0];
            return $address;
        }
        return [];
    }

    /**
     * 根据经纬度或地址来获得静态地图
     * http://api.map.baidu.com/staticimage/v2?ak=E4805d16520de693a3fe707cdc962045&mcode=666666&center=116.403874,39.914888&width=300&height=200&zoom=11
     */
    public static function staticImage($center){
        if(!$center){
            return null;
        }
        $data=[
            'ak'=>config('map.ak'),
            'center'=>$center,
            'with'=>400,
            'height'=>300,
            'zoom'=>11
        ];
        $url=config('map.baidu_map_url').config('map.staticimage').'?'.http_build_query($data);
        return $url;
    }
}