<?php
//大写数字
const lowu = ["零","壹","贰","叁","肆","伍","陆","柒","捌","玖"];
//数字描述
const ns =["","拾","佰","仟"];
//节点值
const zns = ["圆","万","亿","万亿","亿亿"];

function getLage($num)
{
    $lowu = ["零","壹","贰","叁","肆","伍","陆","柒","捌","玖"];
    $ns = ["","拾","佰","仟"];
    $zns = ["圆","万","亿","万亿"];

    if(!is_numeric($num))
    {
        return "零元整";
    }

    if($num >= 1000000000000){  //1 0000 0000 0000  最大一万亿
        return "数值超过万亿";
    }

    $snum = ltrim((string)round($num,2),'0'); //只取两位小数
    //分别获取数字的整数部分和小数部分
    $arr = explode(".",$snum);

    $zs = $arr[0];  //整数
    $xs = key_exists(1,$arr)?$arr[1]:0; //小数
    $str = "";

    //如果太大 超过万亿 就不处理了
    //先处理小数部分
    if($xs && $xs>0)
    {
        $str .= $lowu[$xs[0]]."角".(strlen($xs)>1?($lowu[$xs[1]]."分"):"");
    }else{
        $str .= "整";
    }

    //处理整数部分
    $zstr = "";
    $zlen=strlen($zs);  //获取整数正度
    $zs = strrev($zs); //反转整数  从小->大开始处理
    for($i=0;$i<$zlen;$i++)
    {
        $j = $i%4;
        //每4位处理一次
        if($j == 0){
            if((int)substr($zs,$i,4) || $i == 0)
            {
                $zstr = $zns[$i/4].$zstr; //拼接节点值
            }else{
                //4位全是0
                $zstr =($i>0&&$zs[$i-1]!=0?"零":"").$zstr; //4位区间
                $i+=3;
                continue;
            }
        }
        if($zs[$i] == 0){
            if($i>0 && $zs[$i-1] != 0 && $j != 0){
                $zstr = $lowu[$zs[$i]].$zstr;
            }
        }else{
            $zstr = $lowu[$zs[$i]].$ns[$j].$zstr;
        }
    }

    $str = $zstr.$str;

    return $str;
}



$num=600100001; //  6 0000 0000 8011

echo (string)$num."<br/>";

var_dump(getLage($num));






