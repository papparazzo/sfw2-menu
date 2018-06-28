<?php

/**
 *  SFW2 - SimpleFrameWork
 *
 *  Copyright (C) 2017  Stefan Paproth
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

namespace SFW2\Menu\Menu;

use SFW2\Routing\PathMap\PathMap;
use SFW2\Core\Database;
use SFW2\Core\Permission\PermissionInterface;

class Menu {

    /**
     * @var \SFW2\Permission\PermissionInterface
     */
    protected $permission = null;

    /**
     * @var \SFW2\Core\Database;
     */
    protected $database = null;

    /**
     * @var \SFW2\Routing\PathMap
     */
    protected $pathMap;

    public function __construct(Database $database, PathMap $path, PermissionInterface $permission) {
        $this->database = $database;
        $this->pathMap = $path;
        $this->permission = $permission;
    }

    public function getMainMenu() {
        return $this->getMenu(0, 1, $this->pathMap->getPathIdOfCurrentTopPath());
    }

    public function getSideMenu() {
        return $this->getMenu(
            $this->pathMap->getPathIdOfCurrentTopPath(),
            2,
            $this->pathMap->getPathIdOfCurrentPath()
        );
    }

    public function getFullMenu() {
        return $this->getMenu(0, -1);
    }

    protected function getMenu(int $parentId, $depth, $checked = 0) {
        $stmt =
            "SELECT `menu`.`Id`, `ParentPathId`, `menu`.`Name`, `Position`, " .
            "`sfw2_path`.`ControllerTemplateId`, " .
            "UNIX_TIMESTAMP(`sfw2_path`.`ModificationDate`) AS `LastModified` " .
            "FROM  `sfw2_menu` AS `menu` " .
            "LEFT JOIN `sfw2_path` " .
            "ON `menu`.`Id` = `sfw2_path`.`Id` " .
            "WHERE `ParentPathId` = '%s' " .
            "ORDER BY `Position` ASC";

        $res = $this->database->select($stmt, [$parentId]);

        $map = [];

        foreach($res as $row) {
            if(!$this->permission->getPagePermission($row['Id'])->readOwnAllowed()) {
                continue;
            }

            $url = '';
            if($row['ControllerTemplateId'] != 0) {
                $url = $this->pathMap->getPath($row['Id']);
            }
            $status = MenuItem::STATUS_IS_NORMAL;
            if($row['Id'] == $checked) {
                $status |= MenuItem::STATUS_IS_CHECKED;
            }

            if(time() - $row['LastModified'] < (7 * 60 * 60 * 24)) {
                $status |= MenuItem::STATUS_IS_MODIFIED;
            }

            $item = new MenuItem($row['Name'], $url, $status);
            if($depth > 1) {
                $item->addSubMenuItems($this->getMenu($row['Id'], $depth - 1, $checked));
            } else if($depth == -1) {
                $item->addSubMenuItems($this->getMenu($row['Id'], $depth, $checked));
            }
            $map[] = $item;
        }
        return $map;
    }
}
