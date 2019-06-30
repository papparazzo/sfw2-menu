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

    protected $url;
    protected $displayname;
    protected $status;
    protected $submen = [];
    protected $lastModified;

    public function __construct(string $displayname, string $url, int $lastModified, int $status = self::STATUS_IS_NORMAL) {
        $this->displayname  = $displayname;
        $this->url          = $url;
        $this->status       = $status;
        $this->lastModified = $lastModified;
    }

    public function addSubMenuItem(MenuItem $menuItem) : void {
        $this->submen[] = $menuItem;
    }

    public function addSubMenuItems(array $menuItems) : void {
        $this->submen = array_merge($this->submen, $menuItems);
    }

    public function getURL() : string {
        return $this->url;
    }

    public function getChecked() : int {
        return $this->status & self::STATUS_IS_CHECKED;
    }

    public function getDisplayName() : string {
        return $this->displayname;
    }

    public function getSubMenu() : array {
        return $this->submen;
    }

    public function isRrecentlyModified() : bool {
        return
            $this->hasNewContent() ||
            $this->hasNewContentSubMenu($this->submen);
    }

    public function getLastModificationDate() : int {
        return $this->getNewestModificationDate($this->submen);
    }

    protected function getNewestModificationDate(array $items) : int {
        $lastModified = $this->lastModified;

        foreach($items as $item) {
            if($lastModified < $item->lastModified) {
                $lastModified = $item->lastModified;
            }

            $lastModifiedSubItems = $this->getNewestModificationDate($item->getSubMenu());

            if($lastModified < $lastModifiedSubItems) {
                $lastModified = $lastModifiedSubItems;
            }
        }
        return $lastModified;
    }

    protected function hasNewContentSubMenu(array $items) : bool {
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

    protected function hasNewContent() : bool {
        return (bool)$this->status & self::STATUS_IS_MODIFIED;
    }
}