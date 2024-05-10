@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    <div style="background-color: rgb(204,204,204);">
        <form action="/save" method="POST">
            @csrf
            <div class="document-editor">
                <div id="toolbar-container" class="document-editor__toolbar"></div>
                <div class="document-editor__editable-container">
                    <div id="left" style=""></div>
                    <div name="content" id="editor" class="document-editor__editable">
                        <p>The initial editor data.</p>
                    </div>
                    <div id="list" style="width: 100px; margin: 3px;">
                        <input type="text" id="list-input" class="form-control mb-3">
                        <button type="button" id="addItemButton" class="btn btn-primary">Add Item</button>
                        <button type="button" id="getPositionButton" class="btn btn-primary mt-1">Check pos</button>
                        <button type="button" id="test" onclick="collectData()" class="btn btn-primary mt-1">Collector</button>
                        <button type="submit" onclick="return prepareSubmit()" class="btn btn-primary mt-1">Save</button>
                    </div>
                </div>
            </div>
            <div></div>
            
            <input type="hidden" name="secret" id="secret">
            <input type="hidden" name="title" id="title" value="{{ request()->input('name') }}">
            <input type="hidden" name="desc" id="desc" value="{{ request()->input('desc') }}">
            <input type="hidden" name="json_var_string" id="json_var_string">
            
        </form>
        {{-- old code --}}
        {{-- <div class="container-fluid m-9 mt-4 mb-4 p-2 bg-white" style="max-width: 595px; height: 842px; ">
                <form action="/save" method="POST">
                    @csrf
                    <div id="toolbar-container"></div>

                    <!-- This container will become the editable. -->
                    <div name="content" id="editor">
                        <p>This is the initial editor content.</p>
                    </div>
                    <input type="hidden" name="secret" id="secret">
                    <input type="hidden" name="title" id="title" value="{{ request()->input('name') }}">
                    <input type="hidden" name="desc" id="desc" value="{{ request()->input('desc') }}">
                    <input type="hidden" name="json_var_string" id="json_var_string">
                    <button type="submit" onclick="return prepareSubmit()" class="btn btn-primary">Save</button>
                </form>
            </div> --}}

    </div>
    {{-- useless script --}}
    {{-- <script> 
        //HOLY

        class Placeholder extends Plugin {
            static get requires() {
                return [PlaceholderEditing, PlaceholderUI];
            }
        }
        //SHIT
        class PlaceholderCommand extends Command {
            execute({
                value
            }) {
                const editor = this.editor;
                const selection = editor.model.document.selection;

                editor.model.change(writer => {
                    // Create a <placeholder> element with the "name" attribute (and all the selection attributes)...
                    const placeholder = writer.createElement('placeholder', {
                        ...Object.fromEntries(selection.getAttributes()),
                        name: value
                    });

                    // ... and insert it into the document. Put the selection on the inserted element.
                    editor.model.insertObject(placeholder, null, null, {
                        setSelection: 'on'
                    });
                });
            }

            refresh() {
                const model = this.editor.model;
                const selection = model.document.selection;

                const isAllowed = model.schema.checkChild(selection.focus.parent, 'placeholder');

                this.isEnabled = isAllowed;
            }
        }

        class PlaceholderUI extends Plugin {
            init() {
                const editor = this.editor;
                const t = editor.t;
                const placeholderNames = editor.config.get('placeholderConfig.types');

                // The "placeholder" dropdown must be registered among the UI components of the editor
                // to be displayed in the toolbar.
                editor.ui.componentFactory.add('placeholder', locale => {
                    const dropdownView = createDropdown(locale);

                    // Populate the list in the dropdown with items.
                    addListToDropdown(dropdownView, getDropdownItemsDefinitions(placeholderNames));

                    dropdownView.buttonView.set({
                        // The t() function helps localize the editor. All strings enclosed in t() can be
                        // translated and change when the language of the editor changes.
                        label: t('Placeholder'),
                        tooltip: true,
                        withText: true
                    });

                    // Disable the placeholder button when the command is disabled.
                    const command = editor.commands.get('placeholder');
                    dropdownView.bind('isEnabled').to(command);

                    // Execute the command when the dropdown item is clicked (executed).
                    this.listenTo(dropdownView, 'execute', evt => {
                        editor.execute('placeholder', {
                            value: evt.source.commandParam
                        });
                        editor.editing.view.focus();
                    });

                    return dropdownView;
                });
            }
        }

        function getDropdownItemsDefinitions(placeholderNames) {
            const itemDefinitions = new Collection();

            for (const name of placeholderNames) {
                const definition = {
                    type: 'button',
                    model: new ViewModel({
                        commandParam: name,
                        label: name,
                        withText: true
                    })
                };

                // Add the item definition to the collection.
                itemDefinitions.add(definition);
            }

            return itemDefinitions;
        }

        class PlaceholderEditing extends Plugin {
            static get requires() {
                return [Widget];
            }

            init() {
                console.log('PlaceholderEditing#init() got called');

                this._defineSchema();
                this._defineConverters();

                this.editor.commands.add('placeholder', new PlaceholderCommand(this.editor));

                this.editor.editing.mapper.on(
                    'viewToModelPosition',
                    viewToModelPositionOutsideModelElement(this.editor.model, viewElement => viewElement.hasClass(
                        'placeholder'))
                );
                this.editor.config.define('placeholderConfig', {
                    types: ['date', 'first name', 'surname']
                });
            }

            _defineSchema() {
                const schema = this.editor.model.schema;

                schema.register('placeholder', {
                    // Behaves like a self-contained inline object (e.g. an inline image)
                    // allowed in places where $text is allowed (e.g. in paragraphs).
                    // The inline widget can have the same attributes as text (for example linkHref, bold).
                    inheritAllFrom: '$inlineObject',

                    // The placeholder can have many types, like date, name, surname, etc:
                    allowAttributes: ['name']
                });
            }

            _defineConverters() {
                const conversion = this.editor.conversion;

                conversion.for('upcast').elementToElement({
                    view: {
                        name: 'span',
                        classes: ['placeholder']
                    },
                    model: (viewElement, {
                        writer: modelWriter
                    }) => {
                        // Extract the "name" from "{name}".
                        const name = viewElement.getChild(0).data.slice(1, -1);

                        return modelWriter.createElement('placeholder', {
                            name
                        });
                    }
                });

                conversion.for('editingDowncast').elementToElement({
                    model: 'placeholder',
                    view: (modelItem, {
                        writer: viewWriter
                    }) => {
                        const widgetElement = createPlaceholderView(modelItem, viewWriter);

                        // Enable widget handling on a placeholder element inside the editing view.
                        return toWidget(widgetElement, viewWriter);
                    }
                });

                conversion.for('dataDowncast').elementToElement({
                    model: 'placeholder',
                    view: (modelItem, {
                        writer: viewWriter
                    }) => createPlaceholderView(modelItem, viewWriter)
                });

                // Helper method for both downcast converters.
                function createPlaceholderView(modelItem, viewWriter) {
                    const name = modelItem.getAttribute('name');

                    const placeholderView = viewWriter.createContainerElement('span', {
                        class: 'placeholder'
                    });

                    // Insert the placeholder name (as a text).
                    const innerText = viewWriter.createText('{' + name + '}');
                    viewWriter.insert(viewWriter.createPositionAt(placeholderView, 0), innerText);

                    return placeholderView;
                }
            }
        }
</script>  --}}
    <script>
        DecoupledEditor
            .create(document.querySelector('#editor'), {
                /* plugins: ['InlineWidgetPlugin'], */
                // toolbar conf
                toolbar: {
                    items: ['undo', 'redo',
                        '|', 'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        '|', 'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
                        '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: false
                }
            })
            .then(editor => {
                const toolbarContainer = document.querySelector('#toolbar-container');

                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                myEditor = editor;

                function getCursorPosition() {
                    const cursorPosition = editor.model.document.selection.getFirstPosition().offset;
                    console.log("Cursor Position:", cursorPosition);
                    return cursorPosition;
                }

                //haha web moment todo this is ugly :/
                document.getElementById('getPositionButton').addEventListener('click', getCursorPosition);

                function addItem() {
                    var input = document.getElementById("list-input");
                    var text = input.value.trim();

                    if (text !== "") {
                        var itemList = document.getElementById("list");
                        var div = document.createElement("div");
                        var cursorPosition = getCursorPosition();

                        div.classList.add("d-flex", "justify-content-between", "align-items-center", "mb-2");

                        var itemText = document.createElement("span");
                        itemText.textContent = text + " " + cursorPosition;
                        div.appendChild(itemText);

                        var deleteButton = document.createElement("button");
                        deleteButton.innerHTML = '<i class="fas fa-xmark"></i>';
                        deleteButton.classList.add("btn", "btn-danger");
                        deleteButton.onclick = function() {
                            itemList.removeChild(div);
                        };

                        div.appendChild(deleteButton);
                        itemList.appendChild(div);

                        input.value = ""; // Clear input after adding item
                    } else {
                        alert("Please enter some text.");
                    }
                }

                document.getElementById('addItemButton').addEventListener('click', addItem);


            })
            .catch(error => {
                console.error(error);
            });

        function collectData() {
            var listDiv = document.getElementById("list");
            var innerDivs = listDiv.querySelectorAll("div");
            var textArray = [];

            innerDivs.forEach(function(div) {
                var text = div.textContent.trim();
                var number = text.match(/\d+/); // Extract number from text

                text = text.replace(/\d+/g, '').trim();
                // Check if number is found
                if (number !== null) {
                    // If number is found, convert it to a number type
                    number = parseInt(number[0], 10);
                }

                // Push an array containing text and number (if present) into textArray
                textArray.push([text, number]);
            });

            console.log("Text Array:", textArray);

            //store in input hidden
            document.getElementById("json_var_string").value = JSON.stringify(textArray)
        }

        function prepareSubmit() {
            //Array with user-defined variables

            var payload = document.getElementById("editor").innerHTML;
            document.getElementById("secret").value = payload;
            alert(document.getElementById("secret").value);
            return true;
        }
    </script>
@endsection
