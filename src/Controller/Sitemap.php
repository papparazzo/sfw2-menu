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

namespace SFW2\Menu\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SFW2\Database\DatabaseException;
use SFW2\Menu\Menu\Menu;
use SFW2\Render\RenderInterface;

final class Sitemap
{
    public function __construct(
        private readonly Menu $menu,
        private readonly RenderInterface $render
    ) {
    }

    /**
     * @throws DatabaseException
     */
    public function index(Request $request, Response $response, array $data): Response
    {
        return $this->render->render(
            $request,
            $response,
            ['title'=> 'Sitemap', 'sitemapdata' => $this->menu->getFullMenu()],
            'SFW2\\Menu\\Sitemap'
        );
    }
}
