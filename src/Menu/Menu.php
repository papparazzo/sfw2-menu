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

use SFW2\Database\DatabaseException;
use SFW2\Database\DatabaseInterface;
use SFW2\Routing\PathMap\PathMapInterface;

class Menu
{

    #protected PermissionInterface $permission;

    public function __construct(
        protected DatabaseInterface $database,
        protected PathMapInterface  $pathmap
    )
    {
    }

    /**
     * @throws DatabaseException
     */
    public function getFullMenu(): array
    {
        return $this->getMenu(0, -1);
    }

    public function getPath(): PathMapInterface
    {
        return $this->pathmap;
    }

    /**
     * @throws DatabaseException
     */
    protected function getMenu(int $parentId, $depth, $checked = 0): array
    {
        $stmt = /** @lang MySQL */
            "SELECT `menu`.`Id`, `menu`.`Name`, `menu`.`PathId`, `Position`, " .
            "`path`.`ControllerTemplateId`, " .
            "UNIX_TIMESTAMP(`path`.`ModificationDate`) AS `LastModified` " .
            "FROM  `{TABLE_PREFIX}_menu` AS `menu` " .
            "LEFT JOIN `{TABLE_PREFIX}_path` AS `path` " .
            "ON `menu`.`PathId` = `path`.`Id` " .
            "WHERE `ParentId` = %s " .
            "ORDER BY `Position` ";

        $res = $this->database->select($stmt, [$parentId]);

        $map = [];

        foreach ($res as $row) {
            #  TODO:
            #  if(!$this->permission->getPagePermission($row['PathId'])->readOwnAllowed()) {
            #      continue;
            #  }

            $url = '';
            if ($row['ControllerTemplateId'] != 0) {
                $url = $this->pathmap->getPath($row['PathId']);
            }
            $status = MenuItem::STATUS_IS_NORMAL;
            if ($row['PathId'] == $checked) {
                $status |= MenuItem::STATUS_IS_CHECKED;
            }

            if (time() - $row['LastModified'] < (7 * 60 * 60 * 24)) {
                $status |= MenuItem::STATUS_IS_MODIFIED;
            }
            $item = new MenuItem($row['Name'], $url, (int)$row['LastModified'], $status);
            if ($depth > 1) {
                $item->addSubMenuItems($this->getMenu($row['Id'], $depth - 1, $checked));
            } else if ($depth == -1) {
                $item->addSubMenuItems($this->getMenu($row['Id'], $depth, $checked));
            }
            $map[] = $item;
        }
        return $map;
    }
}
