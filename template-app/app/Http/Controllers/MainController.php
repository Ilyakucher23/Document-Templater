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
        $doc_dict = array_combine(request()->doc_vars_names, request()->doc_vars);
        // dd($doc_dict);
        $user_id = auth()->user()->id;
        $user_folder = storage_path("app\\userfiles\\{$user_id}\\");
        $filename = $file->filename;

        $old_path = $user_folder . $filename;
        $new_path = $user_folder . "new_" . $filename;

        // dd($new_path);

        // $storagePath = $file->link();
        \Illuminate\Support\Facades\File::copy($old_path, $new_path);

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
        $redacted = self::removeEverythingExceptTable($redacted);

        //dd($redacted);
        //$redacted = '<table style="width: 100%; border: 1px solid black;"><tbody><tr><td class="ck-editor__editable ck-editor__nested-editable" role="textbox" tabindex="-1" contenteditable="true" colspan="2" style="width: 100%;"><span class="ck-table-bogus-paragraph">1</span></td></tr><tr><td class="ck-editor__editable ck-editor__nested-editable" role="textbox" tabindex="-1" contenteditable="true" style="width: 50%;"><span class="ck-table-bogus-paragraph">2</span></td><td class="ck-editor__editable ck-editor__nested-editable" role="textbox" tabindex="-1" contenteditable="true" rowspan="2" style="width: 50%;"><span class="ck-table-bogus-paragraph">3</span></td></tr><tr><td class="ck-editor__editable ck-editor__nested-editable" role="textbox" tabindex="-1" contenteditable="true" style="width: 100%;"><span class="ck-table-bogus-paragraph">4</span></td></tr></tbody></table><p>The initial editor data.${1}</p>';


        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        Html::addHtml($section, $redacted);

        $user_id = auth()->user()->id;
        $user_folder = storage_path("app\\userfiles\\{$user_id}\\");
        $filename = Str::random(32) . ".docx";
        $file_path = $user_folder . $filename;


        $phpWord->save($file_path, 'Word2007');

        $file = \App\Models\File::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'filename' => $filename,
            'params' => $request->json_var_string,
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

    static function removeQuotesFromFontFamily($html)
    {
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

    static function removeEverythingExceptTable($html)
    {
        // Regular expression to match <figure> elements with their content except <table> elements
        $pattern = '/<figure[^>]*>.*?(<table.*?<\/table>).*?<\/figure>/is';
        // Replacement pattern to keep only the <table> content and add default styles if not present
        $replacement = '$1';

        // Perform the replacement to isolate the table
        $html = preg_replace($pattern, $replacement, $html);

        // Regular expression to add default styles to the table if they are not already present
        $stylePattern = '/<table(?!.*style=").*?>/';
        $styleReplacement = '<table style="width: 100%; border: 1px solid black;">';

        // Add the styles to the table
        $html = preg_replace($stylePattern, $styleReplacement, $html);

        // Helper function to add or update style attribute
        function addOrUpdateStyle($attributes, $newStyle)
        {
            if (preg_match('/style="([^"]*)"/', $attributes, $styleMatches)) {
                $existingStyles = $styleMatches[1];
                // Merge new style with existing styles
                $newStyles = preg_replace('/width:\s*\d+%/', $newStyle, $existingStyles);
                if (strpos($newStyles, $newStyle) === false) {
                    $newStyles .= ' ' . $newStyle;
                }
                return str_replace($existingStyles, $newStyles, $attributes);
            } else {
                return $attributes . ' style="' . $newStyle . '"';
            }
        }

        // Calculate the width percentage for each cell based on the number of columns
        $html = preg_replace_callback('/<table[^>]*>(.*?)<\/table>/is', function ($matches) {
            $tableContent = $matches[1];

            // Find the number of columns by counting the number of <td> in the first <tr>
            if (preg_match('/<tr>(.*?)<\/tr>/is', $tableContent, $rowMatches)) {
                $firstRow = $rowMatches[1];
                preg_match_all('/<td[^>]*>/', $firstRow, $tdMatches);
                $numColumns = count($tdMatches[0]);

                if ($numColumns > 0) {
                    $widthPercentage = 100 / $numColumns;

                    // Add or update the width style to each <td>
                    $tableContent = preg_replace_callback('/<td([^>]*)>/', function ($tdMatches) use ($widthPercentage) {
                        $tdAttributes = $tdMatches[1];
                        $newStyle = 'width: ' . $widthPercentage . '%;';

                        return '<td' . addOrUpdateStyle($tdAttributes, $newStyle) . '>';
                    }, $tableContent);
                }
            }

            return '<table style="width: 100%; border: 1px solid black;">' . $tableContent . '</table>';
        }, $html);

        return $html;
    }
}
