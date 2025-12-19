<?php 
use ItForFree\SimpleAsset\SimpleAssetManager;
use application\assets\BootstrapAsset;
use application\assets\CustomCSSAsset;

BootstrapAsset::add();
CustomCSSAsset::add();
SimpleAssetManager::printCss();
?>