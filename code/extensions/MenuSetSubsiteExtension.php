<?php

/**
 * Adds subsite support if installed
 *
 * @package silverstripe
 * @subpackage silverstripe-menus
 */
class MenuSetSubsiteExtension extends DataExtension
{
    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = array(
        'Subsite' => 'Subsite'
    );

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $owner = $this->owner;
        $fields->addFieldToTab(
            "Root.Main",
            HiddenField::create(
                'SubsiteID',
                'SubsiteID',
                Subsite::currentSubsiteID()
            )
        );
        return $fields;
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        $owner = $this->owner;
        if(!$owner->ID && !$owner->SubsiteID) $owner->SubsiteID = Subsite::currentSubsiteID();
        parent::onBeforeWrite();
    }
}
