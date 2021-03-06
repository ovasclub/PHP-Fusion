<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.php-fusion.co.uk/
+--------------------------------------------------------*
| Filename: Panel/panel_admin.php
| Author: Frederick MC Chan (Chan)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

/**
 * Class panelWidgetAdmin
 */
class panelWidgetAdmin extends \PHPFusion\Page\Composer\Network\ComposeEngine implements \PHPFusion\Page\WidgetAdminInterface {

    private static $widget_data = array();

    public function exclude_return() {
    }

    public function validate_settings() {
    }

    public function validate_input() {
        self::$widget_data = array(
            'panel_include' => form_sanitizer($_POST['panel_include'], '', 'panel_include')
        );
        if (\defender::safe()) {
            return \defender::serialize(self::$widget_data);
        }
    }

    public function validate_delete() {
    }

    public function display_form_input() {

        $widget_locale = fusion_get_locale('', WIDGETS."/panel/locale/".LANGUAGE.".php");
        self::$widget_data = array(
            'panel_include' => '',
        );
        if (!empty(self::$colData['page_content'])) {
            self::$widget_data = \defender::unserialize(self::$colData['page_content']);
        }
        // Installed panel is displayed here. The visibility should be also seperately configured
        $panel_alt = str_replace(
            array("[LINK]", "[/LINK]"),
            array(
                "<a href='".ADMIN."panels.php".fusion_get_aidlink()."' title='".$widget_locale['0100']."'>",
                "</a>"
            ), $widget_locale['0201']);
        echo form_select('panel_include', $widget_locale['0200'], self::$widget_data['panel_include'],
                         array(
                             'inline' => TRUE,
                             'options' => \PHPFusion\Panels::get_available_panels(),
                             'ext_tip' => $panel_alt,
                         )
        );


    }

    public function display_form_button() {
        $widget_locale = fusion_get_locale('', WIDGETS."/panel/locale/".LANGUAGE.".php");
        echo form_button('save_widget', $widget_locale['0220'], 'widget', array('class' => 'btn-primary'));
        echo form_button('save_and_close_widget', $widget_locale['0221'], 'widget', array('class' => 'btn-success'));
    }

}