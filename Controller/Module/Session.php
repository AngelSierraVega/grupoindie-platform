<?php

/*
 * Copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * This software is protected under GNU: you can use, study and modify it
 * but not distribute it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 */

namespace GIndie\Platform\Controller\Module;

//require_once __DIR__ . '/../model/Login.php';
use GIndie\Generator\DML\HTML5;
use GIndie\Generator\DML\HTML5\Bootstrap3;

/**
 * Defines the default session handler
 * 
 * @version     GIP.00.03
 * 
 * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since       2017-04-23
 */
class Session extends \GIndie\Platform\Controller\Module {

    /**
     * @version     GIP.00.03
     */
    const NAME = "Session";

    /**
     * Description for <b>config</b>.
     * @version     GIP.00.03
     */
    public function config() {
        if (\GIndie\Platform\Current::IsAuthenticated()) {
            //$this->configWidget("i-ii-i")->setTypeCustomContent("[Welcome messaje] [User Info]");
            //$this->configWidget("i-ii-ii")->setTypeCustomContent("[Session info] [btn: Close session]");
            $this->configPlaceholder("i-iii-i")->setTypeRecordInstance(\GIndie\Platform\Current::User(),
                    "Wellcome!");
            $this->configPlaceholder("i-iii-ii")->setTypeRecordInstance(\GIndie\Platform\Current::SessionInfo());

            $btn = new Bootstrap3\Component\Button("Cerrar sesión");
            $btn->setId("gip-close-session");
            $btn->setContext(Bootstrap3\Component\Button::$COLOR_DANGER);
            ob_start();
            ?>

                $('#gip-close-session').on("click", function () {
                    var modalId = "logout";
                    $('#gip-modal').modal("show");
                    $.ajax({
                        type: "POST",
                        data: {'gip-action': 'getModalContent', 'gip-action-id': modalId},
                        url: "?",
                        success: function (data) {
                            //$('#gip-modal .modal-content').html(data);
                            $('#gip-modal').html(data);
                        },
                        error: ajaxErrorHandler
                    });
                });

            <?php
            $str = ob_get_contents();
            ob_end_clean();
            $btn->addScriptOnDocumentReady($str);

            $this->configPlaceholder("i-iii-iii")->setTypeCustomContent($btn);
        } else {
            $form = new \GIndie\Platform\View\Form("gip-login-form",
                    new \GIndie\Platform\Model\Session\Login("CREATE"));
            $form->setAction("login");
            $this->configPlaceholder("i-ii-i")->setTypeCustomContent($form);
            $btn = new Bootstrap3\Component\Button("Ingresar",
                    Bootstrap3\Component\Button::TYPE_SUBMIT);
            $btn->setForm("gip-login-form")->setValue("Submit");
            $btn->setContext(Bootstrap3\Component\Button::$COLOR_SUCCESS);
            $this->configPlaceholder("i-ii-ii")->setTypeCustomContent($btn);
        }
    }

    /**
     * 
     * @todo        bootstrap alert on error.
     * 
     * @since       GIP.00.02
     * @author      Angel Sierra Vega <angel.sierra@grupoindie.com>
     * 
     * @version     GIP.00.05
     * 
     * @param       type $id
     * @return      ?
     */
    protected function submitDPR($id) {
        switch ($id) {
            case "login":
                if (($userId = \GIndie\Platform\Security::authenticateUser() ) !== \FALSE) {
                    $response = HTML5\Category\StylesSemantics::Span();
                    $response->addContent("response");
                    $response->addScript("location.replace(location.pathname);");
                    return $response;
                } else {
                    $response = HTML5\Category\StylesSemantics::Span();
                    $response->addContent("Error de usuario o contraseña, inténtelo de nuevo por favor.");
                    return $response;
                }
                break;
            default:
                return parent::submit($id);
        }
    }

}
