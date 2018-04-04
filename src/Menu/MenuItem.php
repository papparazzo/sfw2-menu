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

class MenuItem {

    const STATUS_IS_NORMAL   = 0;
    const STATUS_IS_CHECKED  = 1;
    const STATUS_IS_MODIFIED = 2;
    const STATUS_IS_CLICKED  = 4;

    protected $url;
    protected $displayname;
    protected $status;
    protected $submen       = [];

    public function __construct(string $displayname, string $url, $status = self::STATUS_IS_NORMAL) {
        $this->displayname  = $displayname;
        $this->url          = $url;
        $this->status       = $status;
    }

    public function addSubMenuItem(MenuItem $menuItem) {
        $this->submen[] = $menuItem;
    }

    public function addSubMenuItems(array $menuItems) {
        $this->submen = array_merge($this->submen, $menuItems);
    }

    public function getURL() {
        return $this->url;
    }

    public function getChecked() {
        return $this->status & self::STATUS_IS_CHECKED;
    }

    public function getDisplayName() {
        return $this->displayname;
    }

    public function getSubMenu() {
        return $this->submen;
    }

    public function isRrecentlyModified() {
        return
            $this->hasNewContent() ||
            $this->hasNewContentSubMenu($this->submen);
    }

    protected function hasNewContentSubMenu(Array $items) {
        foreach($items as $item) {
            if($item->hasNewContent()) {
                return true;
            }

            if($this->hasNewContentSubMenu($item->getSubMenu())) {
                return true;
            }
        }
        return false;
    }

    protected function hasNewContent() {
        return $this->status & self::STATUS_IS_MODIFIED;
    }
}