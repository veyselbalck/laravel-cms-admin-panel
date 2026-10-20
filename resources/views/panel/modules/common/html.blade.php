@extends('panel.modules.form')

@section("general-form")
@endsection

@section("module-form")
    <ul class="nav nav-tabs tabs-line pt-2" role="tablist">
        @foreach(getModelLanguages() as $lang)
            <li class="nav-item">
                <button type="button" class="nav-link @if($loop->first) active @endif" role="tab" data-bs-toggle="tab"
                        data-bs-target="#tab-content-{{$lang->code}}"
                        aria-controls="tab-content-{{$lang->code}}"
                        aria-selected="true">
                    {{$lang->name}}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="card mb-4">
        <div class="tab-content">
            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                @php
                    $content   = !empty($model["settings"]["html"][$lang]) ? $model["settings"]["html"][$lang] : '';
                @endphp
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="form-group">
                        <h6>Html İçerik</h6>
                        <textarea name="settings[html][{{$lang}}]" class="form-control codemirror-textarea" id="codemirror-html-{{$lang_code}}">{!! $content !!}</textarea>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('styles')
    <link rel="stylesheet" href="/plugins/codemirror-5.65.12/lib/codemirror.css">
    <link rel="stylesheet" href="/plugins/codemirror-5.65.12/theme/darcula.css">
    <script src="/plugins/codemirror-5.65.12/lib/codemirror.js"></script>
    <style>
        .cm-s-erlang-dark.CodeMirror { background: #002240; color: white; }
        .cm-s-erlang-dark div.CodeMirror-selected { background: #b36539; }
        .cm-s-erlang-dark .CodeMirror-line::selection, .cm-s-erlang-dark .CodeMirror-line > span::selection, .cm-s-erlang-dark .CodeMirror-line > span > span::selection { background: rgba(179, 101, 57, .99); }
        .cm-s-erlang-dark .CodeMirror-line::-moz-selection, .cm-s-erlang-dark .CodeMirror-line > span::-moz-selection, .cm-s-erlang-dark .CodeMirror-line > span > span::-moz-selection { background: rgba(179, 101, 57, .99); }
        .cm-s-erlang-dark .CodeMirror-gutters { background: #002240; border-right: 1px solid #aaa; }
        .cm-s-erlang-dark .CodeMirror-guttermarker { color: white; }
        .cm-s-erlang-dark .CodeMirror-guttermarker-subtle { color: #d0d0d0; }
        .cm-s-erlang-dark .CodeMirror-linenumber { color: #d0d0d0; }
        .cm-s-erlang-dark .CodeMirror-cursor { border-left: 1px solid white; }

        .cm-s-erlang-dark span.cm-quote      { color: #ccc; }
        .cm-s-erlang-dark span.cm-atom       { color: #f133f1; }
        .cm-s-erlang-dark span.cm-attribute  { color: #ff80e1; }
        .cm-s-erlang-dark span.cm-bracket    { color: #ff9d00; }
        .cm-s-erlang-dark span.cm-builtin    { color: #eaa; }
        .cm-s-erlang-dark span.cm-comment    { color: #77f; }
        .cm-s-erlang-dark span.cm-def        { color: #e7a; }
        .cm-s-erlang-dark span.cm-keyword    { color: #ffee80; }
        .cm-s-erlang-dark span.cm-meta       { color: #50fefe; }
        .cm-s-erlang-dark span.cm-number     { color: #ffd0d0; }
        .cm-s-erlang-dark span.cm-operator   { color: #d55; }
        .cm-s-erlang-dark span.cm-property   { color: #ccc; }
        .cm-s-erlang-dark span.cm-qualifier  { color: #ccc; }
        .cm-s-erlang-dark span.cm-special    { color: #ffbbbb; }
        .cm-s-erlang-dark span.cm-string     { color: #3ad900; }
        .cm-s-erlang-dark span.cm-string-2   { color: #ccc; }
        .cm-s-erlang-dark span.cm-tag        { color: #9effff; }
        .cm-s-erlang-dark span.cm-variable   { color: #50fe50; }
        .cm-s-erlang-dark span.cm-variable-2 { color: #e0e; }
        .cm-s-erlang-dark span.cm-variable-3, .cm-s-erlang-dark span.cm-type { color: #ccc; }
        .cm-s-erlang-dark span.cm-error      { color: #9d1e15; }

        .cm-s-erlang-dark .CodeMirror-activeline-background { background: #013461; }
        .cm-s-erlang-dark .CodeMirror-matchingbracket { outline:1px solid grey; color:white !important; }
    </style>
@endsection

@section('scripts')
    <script>
        $(".codemirror-textarea").each(function(index, elem){
            var id = $(elem).attr('id');
            CodeMirror.fromTextArea(document.getElementById(id), {
                lineNumbers: true,
                theme: "erlang-dark",
                mode:  "html",
                styleActiveLine: true,
                matchBrackets: true
            });
        })
    </script>
@endsection
