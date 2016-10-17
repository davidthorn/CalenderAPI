<?php

namespace App\Extensions\Dingo\Transformer\Adapter;

use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use Illuminate\Contracts\Pagination\Paginator as IlluminatePaginator;
use Dingo\Api\Transformer\Adapter\Fractal as BaseFractal;

class Fractal extends BaseFractal implements Adapter
{
    public function transform($response, $transformer, Binding $binding, Request $request)
    {
        $this->parseFractalIncludes($request);

        $resource = $this->createResource($response, $transformer, $binding->getParameters());

        // If the response is a paginator then we'll create a new paginator adapter for Laravel and set the paginator
        // instance on our collection resource.
        if ($response instanceof IlluminatePaginator) {
            $paginator = $this->createPaginatorAdapter($response);

            $resource->setPaginator($paginator);
        }

        if ($this->shouldEagerLoad($response)) {
            $eagerLoads = $this->mergeEagerLoads($transformer, $this->fractal->getRequestedIncludes());

            $response->load($eagerLoads);
        }

        foreach ($binding->getMeta() as $key => $value) {
            $resource->setMetaValue($key, $value);
        }

        $binding->fireCallback($resource, $this->fractal);

        return $this->fractal->createData($resource)->toArray();
    }
}
