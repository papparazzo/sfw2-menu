<?php

/*
 *  Project:    sfw2-menu
 *
 *  Copyright (C) 2019 Stefan Paproth <pappi-@gmx.de>
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

namespace SFW2\Menu\Controller;

use SFW2\Routing\AbstractController;
use SFW2\Routing\Result\Content;

use SFW2\Core\Database;

class PathEdit extends AbstractController {

    protected Database $database;

    public function __construct(int $pathId, Database $database) {
        parent::__construct($pathId);
        $this->database = $database;
    }

    public function index(bool $all = false): Content {
        unset($all);
        $content = new Content('SFW2\\Menu\\PathEdit');
        $content->assign('controllers', $this->getController());
        return $content;
    }


    public function getData(): Content {
        $content = new Content();
        $content->assign('pathData', $this->getPathData());
        return $content;
    }

    protected function getController() {
        $stmt =
            "SELECT `Id`, `DisplayName`, `Description` " .
            "FROM `{TABLE_PREFIX}_controller_template` AS `controller_template` ";
        return $this->database->select($stmt);
    }


    protected function getPathData(int $parentId = 0): array {
        $stmt = /** @lang MySQL */
            "SELECT `Id`, `Name`, `ControllerTemplateId`, `JsonData` " .
            "FROM `{TABLE_PREFIX}_path` " .
            "WHERE `ParentPathId` = '%s'";

        $res = $this->database->select($stmt, [$parentId]);

        $map = [];

        foreach($res as $row) {
            $map[] = [
                'id' => (int)$row['Id'],
                'name' => $row['Name'],
                'subitems' => $this->getPathData($row['Id'])
            ];
        }
        return $map;
    }
}
