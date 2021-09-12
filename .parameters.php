<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */

use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

if( !Loader::includeModule("highloadblock") ) {
    throw new \Exception('Не загружены модули необходимые для работы компонента');
}

// типы hightload блоков
$rsData = HL\HighloadBlockTable::getList();

// массив имен
$highBlock = [];
while ( $arData = $rsData->fetch()){
    $highBlock[$arData['ID']] = $arData['NAME'];
}

$arComponentParameters = [
    // группы в левой части окна
    "GROUPS" => [
        "SETTINGS" => [
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_SETTINGS'),
            "SORT" => 550,
        ],
    ],
    // поля для ввода параметров в правой части
    "PARAMETERS" => [
        "HIGHLOAD_TYPE" => [
            "PARENT" => "SETTINGS",
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_HIGHLOAD_TYPE'),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $highBlock,
            "REFRESH" => "Y"
        ],
        'OUT_USER_ADDRESS' => [
            'PARENT' => 'SETTINGS',
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_ADDRESS'),
            "TYPE" => "CHECKBOX",
            "ADDITIONAL_VALUES" => "N",
            //"VALUES" => $arIBlock,
            "REFRESH" => "Y"
        ],
        // Настройки кэширования
        'CACHE_TIME' => ['DEFAULT' => 5],
    ]
];