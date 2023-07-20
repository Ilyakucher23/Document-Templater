<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class MainController extends Controller
{
    public function make_doc($id)
    {
        //calc
        return view('document_show');
    }
    public function download_doc($id)
    {

        $doc_vars = request()->doc_vars;
        $storagePath = Storage::disk('local')->path('tempuser/');
        $templateProcessor = new TemplateProcessor($storagePath . 'DoctorTemplate.docx');
        // dd($templateProcessor);
        foreach ($doc_vars as $i => $var) {
            $templateProcessor->setValue($i, $var);
        }
        $templateProcessor->saveAs($storagePath . 'DoctorDocument.docx');

        // dd($templateProcessor);
        // $result = Storage::download('tempuser/DoctorDocument.docx');
        // unlink($storagePath . "DoctorDocument.docx");

        return response()->download($storagePath . '\\DoctorDocument.docx')->deleteFileAfterSend(true);



        // $filename = 'DoctorTemplate.docx';
        // header("Content-Description: File Transfer");
        // header('Content-Disposition: attachment; filename="' . $filename . '"');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        // header('Content-Transfer-Encoding: binary');
        // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // header('Expires: 0');

        // $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $xmlWriter->save("php://output");
    }
}
