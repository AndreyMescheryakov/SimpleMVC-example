<?php
namespace application\assets;
use ItForFree\SimpleAsset\SimpleAsset;

class MyFirstCMSAsset extends SimpleAsset {
    
    public $basePath = '/';  // Корень - web/
    
    public $css = [
        'CSS/my-first-cms-style.css'  // Путь от корня web/
    ];
    
    public $needs = [    
       //\application\assets\CustomCSSAsset::class  // Подключаем после существующих стилей
    ];     
}