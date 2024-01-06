@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    <div>
        <form action="/save" method="POST">
            @csrf
            <div id="toolbar-container"></div>

            <!-- This container will become the editable. -->
            <div name="content" id="editor">
                <p>This is the initial editor content.</p>
            </div>
            <input type="hidden" name="secret" id="secret">
            <button type="submit" onclick="return prepareSubmit()" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script>
        DecoupledEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                const toolbarContainer = document.querySelector('#toolbar-container');

                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                myEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        function prepareSubmit() {
            var payload = document.getElementById("editor").innerHTML;
            document.getElementById("secret").value = payload;
            alert(document.getElementById("secret").value);
            return true;
        }
    </script>
@endsection
