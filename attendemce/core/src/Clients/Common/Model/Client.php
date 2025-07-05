<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 5:53 PM
 */

namespace Clients\Common\Model;

use Classes\ModuleAccess;
use Model\BaseModel;

class Client extends BaseModel
{
    public $table = 'Clients';
    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        return array("get","element","save","delete");
    }

    public function getModuleAccess()
    {
        return [
            new ModuleAccess('clients', 'admin'),
        ];
    }

    public function isCustomFieldsEnabled()
    {
        return true;
    }
}
