<?php

namespace App\Http\Controllers;

use App\Attributes\Rules;
use App\Attributes\TransformCollection;
use App\Attributes\TransformItem;
use App\Exceptions\RouteNotFoundException\RouteNotFoundException;
use App\Http\Controllers\Apis\AuthApiController;
use App\Http\Controllers\Apis\CommonsApiController;
use App\Http\Controllers\Apis\CompanyAuthApiController;
use App\Http\Controllers\Apis\CompaniesApiController;
use App\Http\Controllers\Apis\DashboardApiController;
use App\Http\Controllers\Apis\SetupApiController;
use App\Middlewares\ExceptionHandlingMiddleware;
use App\Middlewares\RouteModelMiddleware;
use App\Middlewares\RulesMiddleware;
use App\Middlewares\TransformerDecorator;
use App\Models\BaseModel;
use App\Transformers\BaseModelTransformer;
use Exedra\Routeller\Attributes\AsFailRoute;
use Exedra\Routeller\Attributes\Decorator;
use Exedra\Routeller\Attributes\Middleware;
use Exedra\Routeller\Attributes\Path;
use Exedra\Routeller\Attributes\Requestable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use League\Fractal\TransformerAbstract;
use Sigil\Context;
#[Path('/apis')]
#[Middleware(ExceptionHandlingMiddleware::class)]
#[Decorator(RouteModelMiddleware::class)]
class ApisController extends Controller
{
    public function middleware(Request $request, $next)
    {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }

        return $next($request);
    }

    public function decorateTransformer(Request $request, $next, Context $context)
    {
        $contents = $next($request);

        $transformItem = $context->getState(TransformItem::class);
        $transformCollection = $context->getState(TransformCollection::class);

        $transformer = BaseModelTransformer::getTransformerIfExist($contents);

        if ($transformer || $transformItem || $transformCollection) {
            /** @var TransformerAbstract $transformer */
            $transformer = $transformer ? new $transformer : ($transformItem ? new $transformItem : new $transformCollection);

            $response = [];

            $serializer = new \App\Transformers\Serializer();

            $fractal = fractal();

            if ($includes = $request->get('includes'))
                $fractal->parseIncludes(is_array($includes) ? $includes : explode(',', $includes));

            if (is_array($contents)) {
                if ($transformItem) {
                    $response['data'] = $fractal
                        ->serializeWith($serializer)
                        ->item($contents)
                        ->transformWith($transformer)
                        ->toArray();
                } if ($transformCollection) {
                    $response['data'] = $fractal
                        ->serializeWith($serializer)
                        ->collection($contents)
                        ->transformWith($transformer)
                        ->toArray();
                }
            }

            if ($contents instanceof \Illuminate\Database\Eloquent\Model) {
                $response['data'] = $fractal
                    ->serializeWith($serializer)
                    ->item($contents)
                    ->transformWith($transformer)
                    ->toArray();
            }

            if ($contents instanceof Collection) {
                $response['data'] = $fractal
                    ->serializeWith($serializer)
                    ->collection($contents)
                    ->transformWith($transformer)
                    ->toArray();
            }

            if ($contents instanceof AbstractPaginator) {
                $response = [];

                $contents->appends($_GET);

                $response['data'] = $fractal
                    ->serializeWith($serializer)
                    ->collection($contents)
                    ->transformWith($transformer)
                    ->toArray();

                $serialized = $contents->toArray();

                unset($serialized['data']);

                $response['pagination'] = $serialized;
            }

            return $response;
        } else if ($contents instanceof Collection) {
            return ['data' => $contents->toArray()];
        } else if ($contents instanceof BaseModel) {
            return ['data' => $contents->toArray()];
        } else if (is_array($contents)) {
            return ['data' => $contents];
        }

        return $contents;
    }

    #[AsFailRoute]
    #[Requestable(false)]
    public function getError()
    {
        throw new RouteNotFoundException();
    }
}
