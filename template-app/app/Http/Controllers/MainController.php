<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;

use PhpOffice\PhpWord\Shared\Html;
use Illuminate\Support\Facades\Auth;

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
    }

    public function editor(Request $request)
    {
        //dd($request);
        return view('editor');
    }

    public function create()
    {
        return view('create_doc');
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

        //dd($request->content);

        // $str = preg_replace('/div>/i', 'p>', $request->secret); //this line is not needed it's related to trix editor 
        /* $redacted = str_replace('<br>','</p><p>',$str); */
        $redacted = str_replace('<br data-cke-filler="true">', '<br data-cke-filler="true" />', $request->secret);
        /*dd($request->secret); */
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        Html::addHtml($section, $redacted);

        $user_id = auth()->user()->id;
        $user_folder = storage_path("app\\userfiles\\{$user_id}\\");
        $filename = Str::random(32) . ".docx";
        $file_path = $user_folder . $filename;


        $phpWord->save($file_path, 'Word2007');

        $file = File::create([
            'filename' => $filename,
            'user_id' => $user_id,
        ]);

        return redirect('/');
    }
    public function templates()
    {
        if (Auth::check()) {
            $templates = Auth::user()->files()->get();
            return view('index', ['templates' => $templates]);
        }
        return view('index', ['templates' => []]);
    }
}
