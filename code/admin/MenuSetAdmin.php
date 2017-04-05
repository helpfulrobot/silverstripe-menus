<?php

/**
 * CMS Admin area to maintain menus
 *
 * @package silverstripe
 * @subpackage menus
 */
class MenuSetAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = array(
        'MenuSet'
    );

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'menus';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title = 'Menus';

    /**
     * @var string
     */
    private static $menu_icon = 'menus/img/menu.png';

    /**
     * @var int
     */
    private static $menu_priority = 9;

    /**
     * @param Int $id
     * @param FieldList $fields
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        $form->Fields()
            ->fieldByName($this->sanitiseClassName($this->modelClass))
            ->getConfig()
            ->removeComponentsByType('GridFieldExportButton')
            ->removeComponentsByType('GridFieldPrintButton');
        return $form;
    }
}
