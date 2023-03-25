<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use SimpleXMLElement;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('file.upload.show', ['title' => 'File upload form', 'not_upload' => false]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    private function parseXML ($fileContent)
    {
        $xml = new SimpleXMLElement($fileContent);
        echo $xml->asXML();
        dd($xml);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xml|max:2048'
        ]);
        $fileModel = new FileUpload();
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->fileName = $fileName;
            $fileModel->filePath = '/storage/' . $filePath;
            $fileModel->save();
            $this->parseXML($request->file('file')->get());
            return back()
                ->with('success','File has been uploaded.')
                ->with('file', $fileName);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileUpload $fileUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileUpload $fileUpload)
    {
        //
    }
}
