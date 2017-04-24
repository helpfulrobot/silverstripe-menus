<?php

/**
 * MenuSet
 *
 * @package silverstripe
 * @subpackage menus
 */
class MenuSet extends DataObject
{
    /**
     * Singular name for CMS
     * @var string
     */
    private static $singular_name = 'Menu';

    /**
     * Plural name for CMS
     * @var string
     */
    private static $plural_name = 'Menus';

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(255)',
        'Slug' => 'Varchar(255)'
    );

    /**
     * Many_many relationship
     * @var array
     */
    private static $many_many = array(
        'Links' => 'MenuLink',
    );

    /**
     * {@inheritdoc }
     * @var array
     */
    private static $many_many_extraFields = array(
        'Links' => array(
            'Sort' => 'Int'
        )
    );

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = array(
        'Title' => 'Title',
        'Links.count' => 'Links'
    );

    /**
     * Defines a default list of filters for the search context
     * @var array
     */
    private static $searchable_fields = array(
        'Title' => 'Title'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'Title',
            'Slug',
            'Links'
        ));

        if ($this->ID) {
            $fields->addFieldToTab(
                'Root.Main',
                GridField::create(
                    'Links',
                    'Links',
                    $this->Links(),
                    GridFieldConfig_RelationEditor::create()
                        ->addComponent(new GridFieldOrderableRows('Sort'))
                )
            );
        }
        return $fields;
    }

    /**
     * Creating Permissions.
     * This module is not  intended to allow creating menus via CMS.  However it
     * still allows create via a 3rd party module.
     * @return boolean
     */
    public function canCreate($member = null)
    {
        $cancreate = false;
        $this->extend('updateCanCreate', $cancreate);
        return $cancreate;
    }

    /**
     * Deleting Permissions
     * This module is not  intended to allow deleting menus via CMS.  However it
     * still allows delete via a 3rd party module.
     * @param mixed $member
     * @return boolean
     */
    public function canDelete($member = null)
    {
        $candelete = false;
        $this->extend('updateCanDelete', $candelete);
        return $candelete;
    }

    /**
     * Editing Permissions
     * @param mixed $member
     * @return boolean
     */
    public function canEdit($member = null)
    {
        return Permission::check('SITETREEREORGANISE', 'any', $member);
    }

    /**
     * Viewing Permissions
     * @param mixed $member
     * @return boolean
     */
    public function canView($member = null)
    {
        return Permission::check('SITETREEREORGANISE', 'any', $member);
    }

    /**
     * Set up default records based on the yaml config
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        $default_menu_sets = $this->config()->get('sets') ?: array();
        foreach ($default_menu_sets as $slug => $title) {
            $slug = convert::raw2htmlid($slug);
            $existingRecord = MenuSet::get()->filter('Slug', $slug)->first();
            if (!$existingRecord) {
                $set = new MenuSet();
                $set->Slug = $slug;
                $set->Title = $title;
                $set->write();
                DB::alteration_message("Menu '$title' created", 'created');
            }
        }
    }
}
