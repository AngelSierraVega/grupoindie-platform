<?php
/*
 * GIplatform - test 2017-05-21
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package Platform
 *
 * @version GIP.00.0?
 */

namespace GIndie\Platform\View\Widget;

//use GIndie\Platform;
use GIndie\Platform\View;
use GIndie\Platform\Model\ListSimple;
use GIndie\Generator\DML\HTML5\Category\StylesSemantics;

/**
 * Description of WidgetList
 *
 * @version GIP.00.03
 * 
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 */
class WidgetList extends View\Widget
{

    protected $_list;
    protected $_id;
    protected $_selectedId;

    /**
     * WidgetList constructor.
     * 
     * @todo eliminar parametro $id = "treeview"
     * @version GIP.00.03
     * @since   GIP.00.02
     * @param ListSimple $list
     * @param string|null $selectedId
     * @edit  Izmir Sanchez Juarez <izmirreffi@gmail.com>
     */
    public function __construct(ListSimple $list, $selectedId = \NULL)
    {
        $this->_list = $list;
        $this->_id = \GIndie\Platform\Security::tokenize(\get_class($list));
        $this->_selectedId = $selectedId;
        $title = $list::Name();
        parent::__construct($title, \FALSE, static::getContent());
        $this->addButtonHeading(Buttons::Reload(\NULL, $selectedId));
        $relatedRecord = $list::RelatedRecord();
        if ($relatedRecord !== \NULL) {
            $roles = $relatedRecord::getValidRolesFor("gip-create");
            if (\GIndie\Platform\Current::hasRole($roles)) {
                $this->setContext(static::$COLOR_PRIMARY, \TRUE);
                $this->addButtonCreate(urlencode($relatedRecord));
            }
        }
    }

    public function defineScript()
    {
        ob_start();
        ?>
        <script>
            create_jstree("<?= $this->_id; ?>");
        </script>
        <?php
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

    /**
     * @return  string
     * @since   GIP.02
     * @edit  Izmir Sanchez Juarez <izmirreffi@gmail.com>
     */
    protected function getContent()
    {
        $rtnStr = "<input class='form-control' id=\"search_$this->_id\" type=\"text\" placeholder=\"Buscar\">";
        $rtnStr .= "<div class=\"list-group\" id=\"$this->_id\" >";
        $rtnStr .= $this->createListElement($this->_list);
        $rtnStr .= "</div>";
        return $rtnStr;
    }

    protected function createListElement(\Gindie\Platform\Model\ListSimple $ListObject)
    {
        $rtnStr = "";
        foreach ($ListObject->getElements() as $index => $elId) {
            $tmpEl = $ListObject->getElementAt($elId);
            $bntGroup = new StylesSemantics\Div("",
                                                ["class" => "btn-group btn-group-xs"]);
//            if (\GIndie\Platform\Current::hasRole($ListObject::getValidRolesFor("gip-delete"))) {
//                $button = Buttons::Delete($ListObject::RelatedRecord(),
//                                          $tmpEl->getId());
//                $bntGroup->addContent($button);
//            }
//            if (\GIndie\Platform\Current::hasRole($ListObject::getValidRolesFor("gip-edit"))) {
//                $button = Buttons::Edit($ListObject::RelatedRecord(),
//                                        $tmpEl->getId());
//                $bntGroup->addContent($button);
//            }
            if (strcmp($tmpEl->getId(), $this->_selectedId) == 0) {
                $rtnStr .= "<ul><li id=\"" . $tmpEl->getId() . "\" idelement=\"" . $tmpEl->getId() . "\"><a class='jstree-clicked'>" . $bntGroup . " " . $tmpEl->getValue() . "</a>";
            } else {
                $rtnStr .= "<ul><li id=\"" . $tmpEl->getId() . "\" idelement=\"" . $tmpEl->getId() . "\" ><a>" . $bntGroup . " " . $tmpEl->getValue() . "</a>";
            }
            if (($tmpChild = $tmpEl->getNested()) !== \NULL) {
                $rtnStr .= $this->createListElement($tmpChild);
            }
            $rtnStr .= "</li></ul>";
        }
        return $rtnStr . "";
    }

    public function addButtonCreate($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Create($gipClass, $gipActionId));
    }

    public function addButtonEdit($gipClass, $gipActionId = \NULL)
    {
        $this->addButtonHeading(Buttons::Edit($gipClass, $gipActionId));
    }

}
