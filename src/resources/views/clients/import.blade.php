@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }}</title>
  @include('layouts.common.css-links')
  <style>
    .drag-drop-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        background-color: #fafafa;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    
    .drag-drop-area:hover {
        border-color: #007bff;
        background-color: #f0f7ff;
    }
    
    .drag-drop-area.dragover {
        border-color: #007bff;
        background-color: #e3f2fd;
        border-style: solid;
    }
    
    .drag-drop-area .upload-icon {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 10px;
    }
    
    .drag-drop-area.dragover .upload-icon {
        color: #007bff;
    }
    
    .file-input-hidden {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
    
    .file-info {
        margin-top: 15px;
        padding: 10px;
        background-color: #e8f5e8;
        border: 1px solid #28a745;
        border-radius: 4px;
        display: none;
    }
    
    .file-info.show {
        display: block;
    }
    
    .remove-file {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        margin-left: 10px;
    }
  </style>
@stop

@section('content')

    @include('errors.error-message')
    @include('success.success-message')

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                   Import Clients
                </div>
                <div class="card-body">
                    <form method="post" action="{{route($role_slug .'/import-clients')}}" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="importFile" class="form-label">File to import</label>
                                    
                                    <!-- Drag and Drop Area -->
                                    <div class="drag-drop-area" id="dragDropArea">
                                        <div class="upload-icon">📁</div>
                                        <div>
                                            <strong>Drag and drop your file here</strong><br>
                                            <span class="text-muted">or <span style="color: #007bff;">click to browse</span></span>
                                        </div>
                                        <small class="text-muted mt-2">Supported formats: CSV, Excel (.xlsx, .xls)</small>
                                    </div>
                                    
                                    <!-- Hidden File Input -->
                                    <input type="file" 
                                           name="importFile" 
                                           id="importFile" 
                                           class="file-input-hidden"
                                           accept=".csv,.xlsx,.xls"
                                           required />
                                    
                                    <!-- File Info Display -->
                                    <div class="file-info" id="fileInfo">
                                        <span id="fileName"></span>
                                        <span id="fileSize"></span>
                                        <button type="button" class="remove-file" id="removeFile">✕</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" 
                                            id="btnUpload" 
                                            class="btn btn-outline-primary" 
                                            name="btnUpload" 
                                            disabled>
                                        Upload
                                    </button>
                                    <small class="text-muted ml-2">Please select a file to upload</small>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
@include('layouts.common.scripts')
<script src="{{ asset('js/app.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dragDropArea = document.getElementById('dragDropArea');
    const fileInput = document.getElementById('importFile');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFile');
    const uploadBtn = document.getElementById('btnUpload');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    dragDropArea.addEventListener('drop', handleDrop, false);

    // Handle click to browse
    dragDropArea.addEventListener('click', () => fileInput.click());

    // Handle file input change
    fileInput.addEventListener('change', handleFileSelect);

    // Handle remove file
    removeFileBtn.addEventListener('click', removeFile);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dragDropArea.classList.add('dragover');
    }

    function unhighlight(e) {
        dragDropArea.classList.remove('dragover');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    }

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            displayFileInfo(file);
            enableUpload();
        }
    }

    function displayFileInfo(file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileInfo.classList.add('show');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function removeFile() {
        fileInput.value = '';
        fileInfo.classList.remove('show');
        disableUpload();
    }

    function enableUpload() {
        uploadBtn.disabled = false;
        uploadBtn.nextElementSibling.textContent = 'Ready to upload';
    }

    function disableUpload() {
        uploadBtn.disabled = true;
        uploadBtn.nextElementSibling.textContent = 'Please select a file to upload';
    }
});
</script>

@endsection