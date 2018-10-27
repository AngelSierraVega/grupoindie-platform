<?php
/**
 * Created by PhpStorm.
 * User: dfkuro
 * Date: 01/06/2017
 * Time: 01:57
 */

namespace GIndie\Platform\Model\Session;
use GIndie\Platform\Model\Database\ListSimple;

/**
 * Class UsersList
 *
 * @package GIndie\Platform\Model
 *
 * @version DEPRECATED
 */
class UsersList extends ListSimple
{
    /**
     * @since   GIP.00.01
     */
    const NAME = "Usuarios";

    /**
     * The name of the database
     * @since     GIP.00.01
     */
    const DATABASE = "gip_session";

    /**
     * The name of the table
     * @since     GIP.00.01
     */
    const TABLE = "user";

    /**
     * The name of the table primary key
     * @since   GIP.00.01
     */
    const ROW_ID = "key";

    /**
     * The name of the element from table attribute that is required.
     * @since   GIP.00.03
     */
    const ROW_ELEMENT = "user";


}