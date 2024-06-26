<?php

class Router
{
    /**
     * constructor
     *
     * @param array<string,callable> $routes
     */
    public function __construct(
        private array $routes = [],
    ) {
        //
    }

    /**
     * ルートの追加
     *
     * @param string $path
     * @param callable(...):string $handler
     * @return void
     */
    public function add(string $path, callable $handler): void
    {
        $this->routes[$path] = $handler;
    }

    /**
     * ルーティング処理
     *
     * ルートパラメータを取得してハンドラを実行します
     * ルートパラメータは{param}の形式で指定します
     *
     * @param string $path
     * @return array {
     *   isMatch: bool,
     *   handler: (callable(...):string)|null,
     *   params: array<string,string>,
     * }
     */
    public function route(string $path): array
    {
        foreach ($this->routes as $route => $handler) {
            $pattern = preg_replace('/{[^}]+}/', '([^/]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                return [
                    'isMatch' => true,
                    'handler' => $handler,
                    'params' => array_combine(
                        array_map(fn ($i) => trim($i, '{}'), array_keys($matches)),
                        $matches,
                    ),
                ];
            }
        }

        return [
            'isMatch' => false,
            'handler' => null,
            'params' => [],
        ];
    }
}
