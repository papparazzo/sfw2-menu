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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SFW2\Database\DatabaseException;
use SFW2\Database\DatabaseInterface;
use SFW2\Routing\AbstractController;
use SFW2\Routing\ResponseEngine;

class PathEdit extends AbstractController
{
    public function __construct(
        protected DatabaseInterface $database
    ) {
    }

    /**
     * @throws DatabaseException
     */
    public function index(Request $request, ResponseEngine $responseEngine): Response
    {
        return $responseEngine->render(
            $request,
            $this->getController(),
            'SFW2\\Menu\\PathEdit'
        );
    }

    /**
     * @throws DatabaseException
     */
    protected function getController(): array
    {
        $stmt = /** @lang MySQL */
            "SELECT `Id`, `DisplayName`, `Description` " .
            "FROM `{TABLE_PREFIX}_controller_template` AS `controller_template` ";
        return $this->database->select($stmt);
    }


    /**
     * @throws DatabaseException
     */
    protected function getPathData(int $parentId = 0): array
    {
        $stmt = /** @lang MySQL */
            "SELECT `Id`, `Name`, `ControllerTemplateId`, `JsonData` " .
            "FROM `{TABLE_PREFIX}_path` " .
            "WHERE `ParentPathId` = %s";

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
