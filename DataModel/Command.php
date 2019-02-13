<?php

/**
 * GI-Platform-DVLP - Command
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (c) 2019 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\Platform\DataModel
 *
 * @version 0D.00
 * @since 19-03-27
 */

namespace GIndie\Platform\DataModel;

/**
 * Description of Command
 *
 * @edit 19-03-28
 * - Moved from GIndie\Platform\Model\Record
 * @todo Implement Help funcionality
 * @todo Implement Chained | Forward commands
 * @todo Implement Instanced & Noninstanced commands.
 * @todo Implement requirements.
 */
class Command
{

    /**
     * 
     * @var string 
     * @since 19-03-27
     * @edit 19-03-28
     */
    private $executableClassname;

    /**
     * 
     * @return string
     * @since 19-03-27
     * @edit 19-03-28
     */
    public function getExecutableClassname()
    {
        return $this->executableClassname;
    }

    /**
     * 
     * @var string 
     * @since 19-03-27
     * @edit 19-03-28
     */
    private $commandId;

    /**
     * 
     * @return string
     * @since 19-03-27
     * @edit 19-03-28
     */
    public function getCommandId()
    {
        return $this->commandId;
    }

    /**
     * 
     * @var array|null
     * @since 19-03-27
     */
    private $requiredRoles;

    /**
     * 
     * @return array|null
     * @since 19-03-27
     */
    public function getRequiredRoles()
    {
        return $this->requiredRoles;
    }

    /**
     * 
     * @var string
     * @since 19-03-27
     */
    private $name;

    /**
     * 
     * @return string
     * @since 19-03-27
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @var string|null
     * @since 19-03-27
     */
    private $description = null;

    /**
     * 
     * @return string|null
     * @since 19-03-27
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 
     * @var string 
     * @since 19-03-27
     */
    private $context;

    /**
     * 
     * @return string
     * @since 19-03-27
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * 
     * @var string|null
     * @since 19-03-27
     */
    private $icon;

    /**
     * 
     * @return string|null
     * @since 19-03-27
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * 
     * @var string 
     * @since 19-03-27
     * @edit 19-03-28
     */
    private $size;

    /**
     * 
     * @return string
     * @since 19-03-27
     * @edit 19-03-28
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * 
     * @param string $commandId
     * @param string $executableClassname
     * @param string $name
     * 
     * 
     * @since 19-03-27
     * @edit 19-03-28
     */
    public function __construct($commandId, $executableClassname, $name)
    {
        $this->commandId = $commandId;
        $this->executableClassname = $executableClassname;
        $this->name = $name;
        $this->context = "default";
        $this->icon = null;
        $this->size = "md";
    }

    /**
     * 
     * @param string $context
     * @param string|null $icon
     * @param string $size
     * 
     * @since 19-03-28
     * 
     * @return \GIndie\Platform\DataModel\Command
     */
    public function setAccess($context = "default", $icon = null, $size = "md")//
    {
        $this->context = $context;
        $this->icon = $icon;
        $this->size = $size;
        return $this;
    }

    /**
     * 
     * @param array|null $requiredRoles
     * @return \GIndie\Platform\DataModel\Command
     * 
     * 
     * @since 19-03-28
     * 
     * @todo Other prerequisites. AttributeEquals | AttributeEvaluation
     * 
     */
    public function definePrerequisites($requiredRoles = null)
    {
        $this->requiredRoles = $requiredRoles;
        return $this;
    }

    /**
     * 
     * @param array $requiredRoles
     * @return \GIndie\Platform\DataModel\Command
     * @since 19-03-27
     * @edit 19-03-28
     * @deprecated since 19-03-27 Use definePrerequisites instead
     */
    public function setRequiredRoles($requiredRoles)
    {
        $this->requiredRoles = $requiredRoles;
        return $this;
    }

    /**
     * 
     * @param string $description
     * @return \GIndie\Platform\DataModel\Command
     * @since 19-03-27
     * @edit 19-03-28
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 
     * @return \GIndie\Platform\DataModel\Command
     * @since 19-03-28
     */
    public function setExecutableClassname($executableClassname)
    {
        $this->executableClassname = $executableClassname;
        return $this;
    }

}
