<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
/**
 * @group Images
 * APIs for Images
 */
class ImagesController extends Controller
{
    /**
     * Get Images by Course and User
     *
     * Get the images by course ID and user ID
     *
     * @response {
     *    "data": [
     *      {
     *          "id": 0,
     *          "iamge": "binary",
     *          "superarea_id": 4,
     *          "name": "string",
     *          "filename": "string",
     *          "userid":0,
     *          "courseid":0
     *      }
     *    ],
     *    "size": 1
     *   }
     */
    public function getCourseUser($idCourse,$userId){
        $images = Images::where('courseid',$courseId)->where('userid',$userId)->get();
        return response()->json(["data"=>$images,"size"=>count($images)]);
    }
    /**
     * Get Images by Course
     *
     * Get the images by course ID
     *
     * @response {
     *    "data": [
     *      {
     *          "id": 0,
     *          "iamge": "binary",
     *          "superarea_id": 4,
     *          "name": "string",
     *          "filename": "string",
     *          "userid":0,
     *          "courseid":0
     *      }
     *    ],
     *    "size": 1
     *   }
     */
    public function get($courseId){
        $images = Images::where('courseid',$courseId)->get();
        return response()->json(["data"=>$images,"size"=>count($images)]);
    }
    /**
     * Get Images by User
     *
     * Get the images by user ID
     *
     * @response{
     *    "data": [
     *      {
     *          "id": 0,
     *          "iamge": "binary",
     *          "superarea_id": 4,
     *          "name": "string",
     *          "filename": "string",
     *          "userid":0,
     *          "courseid":0
     *      }
     *    ],
     *    "size": 1
     *   }
     */
    public function getImageUser($idUser){
        $images = Images::where('userid',$idUser)->get();
        return response()->json(["data"=>$images,"size"=>count($images)]);
    }
    /**
     * Create Images
     *
     * Create multiple images, requires all fields. Send by form-data and it is an array
     *
     * @bodyParam data array required array images.
     * @bodyParam data.*.userid int required user by id.
     * @bodyParam data.*.courseid int required course by id.
     * @bodyParam data.*.filename int required file name.
     * @bodyParam data.*.name int required image name.
     *
     * @response {
     *     "resp": "Se creo correctamente"
     * }
     */
    public function create(Request $request){
        $images_request=$request->data;
        //elimino todas las imagenes que se encuentren en el curso con el que edita
        foreach($images_request as $image_request){
            $imagenes = Images::where('userid',$image_request['userid'])->where('courseid',$image_request['courseid'])->get();
            foreach($imagenes as $delete){
                $delete_image = Images::find($delete['id']);
                $delete_image->delete();
            }
        }
        //creo las imagenes nuevamente lo que manda.

        foreach($images_request as $image_request){

                $image = $image_request['image'];


                $images = Images::create(
                    [
                        "userid"=>$image_request['userid'],
                        "courseid"=>$image_request['courseid'],
                        "image"=>$image->openFile()->fread($image->getSize()),
                        "filename"=>$image_request['filename'],
                        "name"=>$image_request['name'],
                    ]
                );

        }
        return response()->json(["resp"=>"success"],200);
        /*$image = $request->file('data');
        if(!$image){

        }
        $images = Images::create(
            [
                "data"=>$image->openFile()->fread($image->getSize()),
                "courseid"=>$request->courseid,
                "userid"=>$request->userid,
                "filename"=>$request->filename,
                "name"=>$request->filename,
            ]
        );
        return response()->json(["resp"=>"success"],200);*/
    }
}
