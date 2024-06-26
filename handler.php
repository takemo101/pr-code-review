<?php

class RequestHandler
{
    /**
     * 一致したルートのハンドラを実行して結果（描画内容）を返却します
     *
     * @param callable $handler
     * @param array $params
     * @return string
     */
    public function handle(
        callable $handler,
        array $params,
    ): string {

        // ルーティングに設定したハンドラにパラメータを渡して実行します

        return $handler(...array_values($params));
    }
}
