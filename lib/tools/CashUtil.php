<?php

/**
 * 金额单位转换
 */
namespace app\lib\tools;

class CashUtil
{
    public static function toSaveFmt($money)
    {
        $arr = explode('.', $money);
        if(count($arr) < 2)
            $arr[] = '00';
        else
            $arr[1] = substr($arr[1].'00', 0, 2);
        return intval($arr[0].$arr[1]);
    }

    public static function toReadFmt($money)
    {
        return sprintf('%01.2f', $money/100);
    }

    public static function toReadShortFmt($money)
    {
        if($money % 100 == 0)
            return sprintf('%d', intval($money/100));
        else if($money % 10 == 0)
            return sprintf('%01.1f', $money/100);
        else
            return sprintf('%01.2f', $money/100);
    }
}