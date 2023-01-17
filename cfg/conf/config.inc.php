<?php

declare(strict_types=1);

$cfg['blowfish_secret'] = '!*jGG$eSn339bFv%Qr$DyoyVvZWUu7Jv';
$i = 0;
$i++;
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['AllowNoPassword'] = false;

$cfg['Servers'][$i]['controlhost'] = 'localhost';
// $cfg['Servers'][$i]['controlport'] = '';
$cfg['Servers'][$i]['controluser'] = 'root';
$cfg['Servers'][$i]['controlpass'] = 'sqrt';

$cfg['Servers'][$i]['pmadb'] = 'phpmyadmin';
$cfg['Servers'][$i]['bookmarktable'] = 'pma__bookmark';
$cfg['Servers'][$i]['relation'] = 'pma__relation';
$cfg['Servers'][$i]['table_info'] = 'pma__table_info';
$cfg['Servers'][$i]['table_coords'] = 'pma__table_coords';
$cfg['Servers'][$i]['pdf_pages'] = 'pma__pdf_pages';
$cfg['Servers'][$i]['column_info'] = 'pma__column_info';
$cfg['Servers'][$i]['history'] = 'pma__history';
$cfg['Servers'][$i]['table_uiprefs'] = 'pma__table_uiprefs';
$cfg['Servers'][$i]['tracking'] = 'pma__tracking';
$cfg['Servers'][$i]['userconfig'] = 'pma__userconfig';
$cfg['Servers'][$i]['recent'] = 'pma__recent';
$cfg['Servers'][$i]['favorite'] = 'pma__favorite';
$cfg['Servers'][$i]['users'] = 'pma__users';
$cfg['Servers'][$i]['usergroups'] = 'pma__usergroups';
$cfg['Servers'][$i]['navigationhiding'] = 'pma__navigationhiding';
$cfg['Servers'][$i]['savedsearches'] = 'pma__savedsearches';
$cfg['Servers'][$i]['central_columns'] = 'pma__central_columns';
$cfg['Servers'][$i]['designer_settings'] = 'pma__designer_settings';
$cfg['Servers'][$i]['export_templates'] = 'pma__export_templates';

$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

// $cfg['RowActionType'] = 'icons';
// $cfg['ShowAll'] = true;
// $cfg['MaxRows'] = 50;
// $cfg['ProtectBinary'] = false;
// $cfg['DefaultLang'] = 'en';
// $cfg['DefaultLang'] = 'de';
// $cfg['PropertiesNumColumns'] = 2;
// $cfg['QueryHistoryDB'] = true;
// $cfg['QueryHistoryMax'] = 100;
// $cfg['SendErrorReports'] = 'always';
// $cfg['URLQueryEncryption'] = true;
// $cfg['URLQueryEncryptionSecretKey'] = '';