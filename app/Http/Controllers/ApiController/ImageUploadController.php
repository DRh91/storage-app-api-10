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

class ImageUploadController extends Controller
{
    public function upload(Request $request): JsonResource
    {
        $base64 = $request->get('base64') ?? null;
        if ($base64 === null) {
            return new JsonResource(["success" => false, "message" => "base64 missing"]);
        }

        $filename = $request->get('filename') ?? null;
        if ($filename === null) {
            return new JsonResource(["success" => false, "message" => "filename missing"]);
        }

        $base64 = base64_decode($base64);
        $directory = public_path(). '\\images';
        $status = file_put_contents($directory . '\\' . $filename, $base64);

        if (!$status) {
            return new JsonResource([["success" => false, "message" => "Unable to upload image."]]);
        }

        return new JsonResource([["success" => true, "message" => "Image has been uploaded successfully."]]);
    }

}
