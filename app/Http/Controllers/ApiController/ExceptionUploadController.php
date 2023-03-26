<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class ExceptionUploadController extends Controller
{

    public function upload(Request $request): JsonResource
    {
        $class = $request->get("class");
        $message = $request->get("message");
        $stacktrace = $request->get("stacktrace");
        DB::table('app_exceptions')->insert(['class' => $class, 'stacktrace' => $stacktrace, 'message' => $message]);
        return new JsonResource(['success' => true]);
    }

}
