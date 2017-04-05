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
        return MenuSet::get()
            ->filter(
                array(
                    'Slug' => $slug
                )
            )->first()->Links()->sort('Sort ASC');
    }
}
