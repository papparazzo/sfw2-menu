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

use SFW2\Routing\AbstractController;
use SFW2\Routing\Result\Content;
use SFW2\Menu\Menu\Menu;

class Sitemap extends AbstractController {

    /**
     * @var \SFW2\Routing\Menu
     */
    protected $menu = null;

    public function __construct(int $pathId, Menu $menu) {
        $this->menu = $menu;
        parent::__construct($pathId);
    }

    public function index($all = false) {
        unset($all);
        $content = new Content('SFW2\\Menu\\Sitemap');
        $content->assign('title', 'Sitemap');
        $content->assign('sitemapdata', $this->menu->getFullMenu());
        return $content;
    }
}
