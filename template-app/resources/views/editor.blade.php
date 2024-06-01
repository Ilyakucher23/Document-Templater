@extends('template')

{{-- @section('head')
<script src="{{ asset('assets/vendor/ckeditor5/build/my-plugin.js') }}"></script>
@endsection --}}

@section('title')
    Головна сторінка
@endsection

@section('content')
    <div>
        <form action="/save" method="POST">
            @csrf
            <div class="document-editor">
                <div id="toolbar-container" class="document-editor__toolbar"></div>
                <div class="document-editor__editable-container">
                    <div id="left" style=""></div>
                    <div name="content" id="editor" class="document-editor__editable">
                        @lang('public.<p>The initial editor data.</p>')
                    </div>
                    <div id="list" style="width: 150px; margin: 3px;">
                        <input type="text" id="list-input" class="form-control mb-3" placeholder="@lang('public.variable_name')">
                        <button type="button" id="addItemButton" style="width: 100%"
                            class="btn btn-primary">@lang('public.add_item')</button>
                        <button type="submit" onclick="return prepareSubmit()" style="width: 100%"
                            class="btn btn-primary mt-1">@lang('public.save')</button>
                    </div>
                </div>
            </div>
            <div></div>

            <input type="hidden" name="secret" id="secret">
            <input type="hidden" name="title" id="title" value="{{ request()->input('name') }}">
            <input type="hidden" name="desc" id="desc" value="{{ request()->input('desc') }}">
            <input type="hidden" name="json_var_string" id="json_var_string">

        </form>


    </div>

    <script>
        var var_array = [];

        function DisallowNestingTables(editor) {
            editor.model.schema.addChildCheck((context, childDefinition) => {
                if (childDefinition.name == 'table' && Array.from(context.getNames()).includes('table')) {
                    return false;
                }
            });
        }
        DecoupledEditor
            .create(document.querySelector('#editor'), {
                /* plugins: ['InlineWidgetPlugin'], */
                extraPlugins: [ DisallowNestingTables ],
                fontSize: {
                    options: [
                        9,
                        11,
                        13,
                        'default',
                        17,
                        19,
                        21
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow']
                },
                // toolbar conf
                toolbar: {
                    items: ['undo', 'redo',
                        '|', 'alignment', 'fontfamily', 'fontsize', '|', 'fontColor', 'fontBackgroundColor',
                        '|', 'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                        '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent', 'insertTable'
                    ],
                    shouldNotGroupWhenFull: false
                }
            })
            .then(editor => {
                const toolbarContainer = document.querySelector('#toolbar-container');


                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                myEditor = editor;

                function getCursorPosition() {
                    const selection = editor.model.document.selection;
                    const position = selection.getFirstPosition();
                    const parent = position.parent;
                    const offset = position.offset;
                    // console.log(selection, position, parent, offset);

                    return [parent.getPath()[0], offset];
                }


                function addItem() {
                    const model = editor.model;
                    const selection = model.document.selection;
                    const position = selection.getFirstPosition();
                    var text = document.getElementById("list-input").value.trim();
                    if (text !== "") {

                        model.change(writer => {
                            writer.insertText('${' + text + "}", position);
                        });
                        document.getElementById("list-input").value = ""; // Clear input after adding item
                    } else {
                        alert("Please enter some text.");
                    }
                    /* var a = document.getElementById("editor").innerHTML.replaceAll("&nbsp;", " ");

                    //alert(a);
                    //document.getElementById("editor".innerText.replaceAll("$nbsp;", " "));
                    console.log(document.getElementById("editor").innerText);
                    var input = document.getElementById("list-input");
                    var text = input.value.trim();

                    if (text !== "") {
                        var itemList = document.getElementById("list");
                        var div = document.createElement("div");
                        var cursorPosition = getCursorPosition();

                        div.classList.add("d-flex", "justify-content-between", "align-items-center", "mb-2");

                        var itemText = document.createElement("span");
                        itemText.textContent = text;
                        itemText.setAttribute("id", "name");
                        div.appendChild(itemText);

                        var itemNumber = document.createElement("span");
                        itemNumber.textContent = cursorPosition[0];
                        itemNumber.setAttribute("id", "first");
                        div.appendChild(itemNumber);

                        var itemNumber = document.createElement("span");
                        itemNumber.setAttribute("id", "second");
                        itemNumber.textContent = cursorPosition[1];
                        div.appendChild(itemNumber);

                        var deleteButton = document.createElement("button");
                        deleteButton.innerHTML = '<i class="fas fa-xmark"></i>';
                        deleteButton.classList.add("btn", "btn-danger");
                        deleteButton.onclick = function() {
                            //var_array.indexOf(itemList.getElementById("name"), itemList.getElementById('first').innerHTML,itemList.getElementById('second').innerHTML)
                            itemList.removeChild(div);
                        };

                        div.appendChild(deleteButton);
                        itemList.appendChild(div);

                        var_array.push([text, cursorPosition[0], cursorPosition[1]]);
                        input.value = ""; // Clear input after adding item

                    } else {
                        alert("Please enter some text.");
                    } */
                }

                document.getElementById('addItemButton').addEventListener('click', addItem);
                window.editor = editor;

            })
            .catch(error => {
                console.error(error);
            });

        function removeDuplicates(arr) {
            return [...new Set(arr)];
        }

        function prepareSubmit() {
            const content = editor.getData();

            // Regular expression to match the pattern ${any_text} followed by a space
            const regex = /\$\{([^}]+)\}/g;

            // Find all matches
            const var_array = [...content.matchAll(regex)].map(match => match[1]);

            document.getElementById("json_var_string").value = JSON.stringify(removeDuplicates(var_array));
            // alert(JSON.stringify(var_array));
            document.getElementById("secret").value = document.getElementById("editor").innerHTML;
            // alert(document.getElementById("secret").value);

            /* document.getElementById("json_var_string").value = JSON.stringify(var_array);
            var payload = document.getElementById("editor").innerText;

            var separateLines = payload.split(/\r?\n|\r|\n/g);

            var_array.sort((a, b) => {
                return b[2] - a[2];
            });
            var_array.sort((a, b) => {
                return a[1] - b[1];
            });

            console.log(var_array);
            for (var i = 0; i < var_array.length; i++) {
                var line = separateLines[var_array[i][1]];
                var insert = '${' + var_array[i][0] + '}';
                var char_i = var_array[i][2];
                var output = [line.slice(0, char_i), insert, line.slice(char_i)].join('');

                separateLines[var_array[i][1]] = output;
            }

            var general_output = separateLines.join('\n');
            console.log(general_output);

            document.getElementById("editor").innerText = general_output;

            document.getElementById("secret").value = document.getElementById("editor").innerHTML;
            alert(document.getElementById("secret").value);
            return true; */
            /* //Array with user-defined variables
            document.getElementById("json_var_string").value = JSON.stringify(var_array);
            //add text to saved cursor positions

            var payload = document.getElementById("editor").getElementsByTagName("p");


            console.log(document.getElementById("editor").innerHTML);
            console.log(JSON.stringify(var_array));

            //console.log(payload[0].innerHTML[2]); //e
            //sort
            var_array.sort((a, b) => {
                return b[2] - a[2];
            });
            var_array.sort((a, b) => {
                return a[1] - b[1];
            });

            for (var i = 0; i < var_array.length; i++) {
                console.log("where to put var = " + payload[var_array[i][1]].innerHTML[var_array[i][2] - 1]);
                Array.prototype.splice.call(payload[var_array[i][1]], 0, var_array[i][0]);
                var text = Array.from(payload[var_array[i][1]].innerHTML);
                console.log("text", text);
                text.splice(var_array[i][2], 0, "${" + var_array[i][0] + "}");
                payload[var_array[i][1]].innerHTML = text.join("");
                //payload[var_array[i][1]].innerHTML.splice(var_array[i][2],0,var_array[i][0])
            }


            console.log("payload =" + payload[0].innerHTML);


            document.getElementById("secret").value = document.getElementById("editor").innerHTML;
            alert(document.getElementById("secret").value);
            return true; */
        }
    </script>
@endsection
