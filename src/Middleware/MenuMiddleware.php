<?php

namespace SFW2\Menu\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SFW2\Database\DatabaseInterface;
use SFW2\Routing\PathMap\PathMapInterface;

class MenuMiddleware implements MiddlewareInterface
{

    public function __construct(
        protected DatabaseInterface $database, // FIXME use repository instead of databaseinterface!
        protected PathMapInterface $pathmap
    )
    {
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $stmt =
            "SELECT `Id`, `Name` As `name`, `PathId`, `Position` FROM `{TABLE_PREFIX}_menu` " .
            "WHERE `ParentId` = 0 " .
            "ORDER BY `Position` ASC";

        $currentPath = $request->getUri()->getPath();

        $activePathId = 0;
        if($this->pathmap->isValidPath($currentPath)) {
            $activePathId = $this->pathmap->getPathId($request->getUri()->getPath());
        }

        $res = $this->database->select($stmt);

        foreach($res as &$item) {
             $item['active'] = ($activePathId == $item["PathId"]);
             $item['href'] = $this->pathmap->getPath($item["PathId"]);
        }

        $request = $request->withAttribute('sfw2_menu', $res);
        return $handler->handle($request);
    }
}