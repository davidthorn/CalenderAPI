<?php

if (! function_exists('api_router')) {
    /**
     * @return \Dingo\Api\Routing\Router
     */
    function api_router()
    {
        return app('api.router');
    }
}

if (! function_exists('api_url')) {
    /**
     * @param null $version
     * @return \Dingo\Api\Routing\UrlGenerator
     */
    function api_url($version = null)
    {
        if (is_null($version)) {
            return app('api.url')->version(env('API_VERSION'));
        }

        return app('api.url')->version($version);
    }
}

if (! function_exists('api_response')) {
    /**
     * @return \App\Services\ApiResponse
     */
    function api_response()
    {
        return app('App\Services\ApiResponse');
    }
}
