<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?

global $USER;
if($USER->IsAuthorized()) {
?>
<table class="iksweb">

        <thead>
        <tr>
            <th> Город </th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($arResult['DATA'] as $userActive) { ?>
        <tr>
            <td><?=$userActive['UF_USER_ADDRESS'] ?></td>
        </tr>
        <? } ?>
        </tbody>
</table>
<? } ?>

