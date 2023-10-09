<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\Html;

use Exception;

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

    }

    public function editor()
    {
        return view('editor');
    }

    public function save(Request $request)
    {
        //dd($request->content);
        /* $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $description = "<p>sdfasdasd</p>";

        $section->addText($description);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {

            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx')); */
        //$htmlTemplate = '<p style=" text-align: center;">asdasdasdasd</p><p>asd<strong>asd</strong></p><p>asdasd</p>';/* ' <p style="background-color:#FFFF00;color:#FF0000;">Some text</p>' */ 
        //dd($redacted);

        $str = preg_replace('/div>/i', 'p>',$request->content);
        $redacted = str_replace('<br>','</p><p>',$str);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        Html::addHtml($section, $redacted);
        $targetFile = __DIR__ . "/1.docx";
        $phpWord->save($targetFile, 'Word2007');
    }
}
