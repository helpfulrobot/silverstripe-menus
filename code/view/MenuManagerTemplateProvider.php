<?php

/**
 * Adds MenuSet variable to templates
 *
 * @package silverstripe
 * @subpackage menus
 */
class MenuManagerTemplateProvider implements TemplateGlobalProvider
{
    /**
     * @return array|void
     */
    public static function get_template_global_variables()
    {
        return array(
            'MenuSet' => 'MenuSet'
        );
    }

    /**
     * @param $title
     * @return DataObject
     */
    public static function MenuSet($slug)
    {
        $filter = array(
            'Slug' => $slug
        );
        if ($MenuSet = MenuSet::get()->filter($filter)->first()) {
            return $MenuSet->Links()->sort('Sort ASC');
        }
    }
}
