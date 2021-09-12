<?php

use \Bitrix\Main\Loader,
    \Bitrix\Main\Application,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class DartTestComponent extends CBitrixComponent {

    /**
     * Проверка наличия модулей требуемых для работы компонента
     * @return bool
     * @throws Exception
     */
    private function _checkModules() {
        if ( !Loader::includeModule("highloadblock") ) {
            throw new \Exception('Не загружены модули необходимые для работы компонента');
        }
        return true;
    }

    public function GetHighLoadBlockData() {
        global $USER;
        $arParams = $this->arParams;

        $hlBlockItems = HL\HighloadBlockTable::getById($arParams['HIGHLOAD_TYPE'])->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlBlockItems);
        $entity_data_class = $entity->getDataClass();

        if($entity_data_class)
        {
            $outPropertyBlock = $entity_data_class::getList(array(
                'select' => ['*'],
                'filter' => [
                    '=UF_USER_ID' => $USER->GetID(),
                    '=UF_USER_ACTIVE' => ($arParams['OUT_USER_ADDRESS'] == 'Y') ? 1 : [1,0]
                ]
            ))->fetchAll();
        }
        return $outPropertyBlock;
    }
    public function CheckModuleParams() {

        // проверка модулей
        $this->_checkModules();

        // проверка параметров
        if(!$this->arParams['HIGHLOAD_TYPE'])
            throw new \Exception('Не выбран HighLoad блок');

        return true;
    }
    
    public function executeComponent() {
        $this->CheckModuleParams();
        $this->arResult['DATA'] = $this->GetHighLoadBlockData();
        $this->includeComponentTemplate();
    }
}
