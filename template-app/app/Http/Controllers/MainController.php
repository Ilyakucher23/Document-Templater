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
    public function make_doc($file_id)
    {
        //calc
        return view('document_show', ['template' => \App\Models\File::find($file_id)]);
    }
    public function download_doc($file_id)
    {
        $file = \App\Models\File::find($file_id);
        // dd($file->link());
        // $doc_vars = request()->doc_vars;
        // $doc_vars_names = request()->doc_vars_names;
        $doc_dict= array_combine(request()->doc_vars_names,request()->doc_vars);
        // dd($doc_dict);
        $user_id = auth()->user()->id;
        $user_folder = storage_path("app\\userfiles\\{$user_id}\\");
        $filename = $file->filename;

        $old_path = $user_folder . $filename;
        $new_path = $user_folder ."new_". $filename;

        // dd($new_path);
        
        // $storagePath = $file->link();
        \Illuminate\Support\Facades\File::copy($old_path,$new_path);
        
        $templateProcessor = new TemplateProcessor($new_path);
        // dd($templateProcessor);
        foreach ($doc_dict as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }
        $templateProcessor->saveAs($new_path);

        // dd($templateProcessor);
        // $result = Storage::download(($storagePath));
        // unlink($storagePath);

        return response()->download(($new_path))->deleteFileAfterSend(true);;
        // return redirect('/');
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
        // top 10 worst code ever written
        // dd($request);
        $redacted = str_replace('<br data-cke-filler="true">', '<br data-cke-filler="true" />', $request->secret);
        // hsl to hex replace will replce until no hsl color
        $redacted  = preg_replace_callback('/hsl\((\d+),\s*(\d+%)\s*,\s*(\d+%)\)/', 'self::hslToHex', $redacted);
        preg_match_all('/hsl\((\d+),/', $redacted, $matches, PREG_SET_ORDER);

        //font family fix
        $redacted = self::removeQuotesFromFontFamily($redacted);
        /*dd($request->secret); */
        //dd($redacted);
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        Html::addHtml($section, $redacted);

        $user_id = auth()->user()->id;
        $user_folder = storage_path("app\\userfiles\\{$user_id}\\");
        $filename = Str::random(32) . ".docx";
        $file_path = $user_folder . $filename;


        $phpWord->save($file_path, 'Word2007');

        $file = \App\Models\File::create([
            'title'=>$request->title,
            'desc'=>$request->desc,
            'filename' => $filename,
            'params'=>$request->json_var_string,
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

    static function ColorHSLToRGB($hue, $saturation, $luminosity)
    {
        $hue = $hue / 360; // Normalize hue to [0, 1]
        $saturation = rtrim($saturation, '%') / 100; // Normalize saturation to [0, 1]
        $luminosity = rtrim($luminosity, '%') / 100; // Normalize luminosity to [0, 1]

        // Calculate RGB values
        $chroma = (1 - abs(2 * $luminosity - 1)) * $saturation;
        $x = $chroma * (1 - abs(fmod($hue * 6, 2) - 1));
        $m = $luminosity - $chroma / 2;

        if ($hue < 1 / 6) {
            list($r, $g, $b) = array($chroma, $x, 0);
        } elseif ($hue < 2 / 6) {
            list($r, $g, $b) = array($x, $chroma, 0);
        } elseif ($hue < 3 / 6) {
            list($r, $g, $b) = array(0, $chroma, $x);
        } elseif ($hue < 4 / 6) {
            list($r, $g, $b) = array(0, $x, $chroma);
        } elseif ($hue < 5 / 6) {
            list($r, $g, $b) = array($x, 0, $chroma);
        } else {
            list($r, $g, $b) = array($chroma, 0, $x);
        }

        // Adjust RGB values and convert to HEX
        $r = round(($r + $m) * 255);
        $g = round(($g + $m) * 255);
        $b = round(($b + $m) * 255);

        return sprintf("#%02X%02X%02X", $r, $g, $b);
    }

    static function removeQuotesFromFontFamily($html) {
        // Regular expression to match font-family names wrapped in single quotes
        $pattern = '/font-family:\'([^\']+)\',/';
        // Replacement pattern to remove the single quotes
        $replacement = 'font-family:$1,';
        // Perform the replacement
        $modifiedHtml = preg_replace($pattern, $replacement, $html);
        return $modifiedHtml;
    }

    static function hslToHex($matches)
    {
        list($fullMatch, $hue, $saturation, $luminosity) = $matches;

        // Convert HSL to HEX
        $hexColor = self::ColorHSLToRGB($hue, $saturation, $luminosity);

        return $hexColor;
    }
}
