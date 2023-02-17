<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use Image;

class ImageUpload extends Controller
{
    /**
     * Penjelasan function
     * patern_filename = nama awalan untuk filenya
     * is_convert = jika ingin di convert
     * file => request->file() dari laravelnya,
     * path => nama path yang akan disimpan
     * convert_extention => pgn ganti format kemana ? jpg, jpeg, png atau yang lainnya defaulnya jpeg
     */
    public function imageUpload($type = 'image', $config_file){
        $file_path = public_path($config_file['path']);

        if(!file_exists($file_path)) mkdir($file_path, 0775, true);

        $data = [];
        $number = 1;
        foreach ($config_file['file'] as $key => $value) {
            $config_init = [
                'key'         => $key,
                'config_file' => $config_file,
                'type'        => $type,
            ];
            if(is_array($value)){
                foreach ($value as $key_value => $item) {
                    $config_init['value'] = $item;
                    $config_init['number'] = $number++;
                    $full_path_name = $this->intiFile($config_init);
                    $data[$key][$key_value] = $full_path_name;
                }
            }else{
                $config_init['value'] = $value;
                $config_init['number'] = $number++;
                $full_path_name = $this->intiFile($config_init);
                $data[$key]    = $full_path_name;
            }
        }

        return $data;
    }

    /**
     * function yaang digunakan untuk resize by dimensi 100,300,500
     * $filename = nama file
     * $file = dari request->file('nama_file_yang_dikirim')
     * $file_path = public_path('path file yang akan diismpan');
     * $convert_extention => pgn ganti format kemana ? jpg, jpeg, png atau yang lainnya defaulnya jpeg
     */
    public function resizeImage($filename, $file, $file_path, $convert_extention = 'jpeg'){
        $dimensi = [
            'sm' => 100,
            'md' => 300,
            'lg' => 500,
        ];

        #save file by dimensi
        foreach ($dimensi as $key => $value_dimensi) {
            $img = Image::make($file->path());
            $img->resize($value_dimensi, $value_dimensi, function ($const) {
                $const->aspectRatio();
            })->encode($convert_extention)->save($file_path.'/'.$filename.'_'.$key.'.'.$convert_extention);
        }
    }

    public function intiFile($config_init){
        // ini_set('upload_max_filesize', "8M");
        $slug_filename = slugCustom($config_init['key']);
        $filename      = $config_init['config_file']['patern_filename'].'-'.$slug_filename.'-'.$config_init['number'].'-'.date("Ymdhis");
        $path = $config_init['config_file']['path'];

        if($config_init['config_file']['is_convert'] && $config_init['type'] == 'image'){
            $full_path_name = $path . '/' . $filename . '_ori' . '.' . $config_init['config_file']['convert_extention'];
            #save file-ori
            Image::make($config_init['value']->path())->encode($config_init['config_file']['convert_extention'])
                ->save($full_path_name);
            #save file ny dimensi
            $this->resizeImage(
                $filename,
                $file = $config_init['value'],
                $file_path = $path,
                $convert_extention = $config_init['config_file']['convert_extention']);
        }else{
            $full_path_name = $path . $filename . '.' . $config_init['value']->extension();
            $config_init['value']->move($path, $full_path_name);
        }

        return $full_path_name;
    }
}
