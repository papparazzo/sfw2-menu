<?php

namespace SFW2\Menu\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SFW2\Core\Interfaces\PathMapInterface;
use SFW2\Core\Permission\AccessType;
use SFW2\Core\Permission\PermissionDummy;
use SFW2\Core\Permission\PermissionInterface;
use SFW2\Database\DatabaseException;
use SFW2\Database\DatabaseInterface;

final class MenuMiddleware implements MiddlewareInterface
{

    public function __construct(
        private readonly DatabaseInterface $database, // FIXME use repository instead of databaseinterface!
        private readonly PathMapInterface  $pathmap,
        private readonly ?PermissionInterface $permission = new PermissionDummy()
    )
    {
    }

    /**
     * @throws DatabaseException
     */
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $stmt =
            "SELECT `Id`, `Name` As `name`, `PathId`, `Position` FROM `{TABLE_PREFIX}_menu` " .
            "WHERE `ParentId` = 0 " .
            "ORDER BY `Position`";

        $currentPath = $request->getUri()->getPath();

        $activePathId = 0;
        if($this->pathmap->hasPath($currentPath)) {
            $activePathId = $this->pathmap->getPathId($request->getUri()->getPath());
        }

        $res = $this->database->select($stmt);

        foreach($res as &$item) {
            if($this->permission->checkPermission($item["PathId"], '*') == AccessType::VORBIDDEN) {
                continue;
            }
            $item['active'] = ($activePathId == $item["PathId"]);
            $item['href'] = $this->pathmap->getPath($item["PathId"]);
        }

        $request = $request->withAttribute('sfw2_menu', $res);
        return $handler->handle($request);
    }
}