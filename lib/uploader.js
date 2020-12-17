
function multiple_file_uploader(configuration_settings)
{
    this.settings = configuration_settings;
    this.files = "";
    this.browsed_files = []
    var self = this;
    var msg = "Desculpe, seu browser não suporta esta aplicação.";

    //Get all browsed file extensions
    function file_ext(file) {
        return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : '';
    }

    /* Display added files which are ready for upload */
    //with their file types, names, size, date last modified along with an option to remove an unwanted file
    multiple_file_uploader.prototype.show_added_files = function(value)
    {
        this.files = value;
        if (this.files.length > 0)
        {
            var added_files_displayer = file_id = "";
            for (var i = 0; i < this.files.length; i++)
            {
                //Use the names of the files without their extensions as their ids
                var files_name_without_extensions = this.files[i].name.substr(0, this.files[i].name.lastIndexOf('.')) || this.files[i].name;
                file_id = files_name_without_extensions.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');

                var file_to_add = file_ext(this.files[i].name);
                var cssclass = $("#added_class").val();
                var file_icon;

                //Check and display File Size
                var fileSize = (this.files[i].size / 1024);
                if (fileSize / 1024 > 1)
                {
                    if (((fileSize / 1024) / 1024) > 1)
                    {
                        fileSize = (Math.round(((fileSize / 1024) / 1024) * 100) / 100);
                        var actual_fileSize = fileSize + " GB";
                    }
                    else
                    {
                        fileSize = (Math.round((fileSize / 1024) * 100) / 100)
                        var actual_fileSize = fileSize + " MB";
                    }
                }
                else
                {
                    fileSize = (Math.round(fileSize * 100) / 100)
                    var actual_fileSize = fileSize + " KB";
                }

                //Check and display the date that files were last modified
                var date_last_modified = new Date(this.files[i].lastModifiedDate);
                var dd = date_last_modified.getDate();
                var mm = date_last_modified.getMonth() + 1;
                var yyyy = date_last_modified.getFullYear();
                var date_last_modified_file = dd + '/' + mm + '/' + yyyy;

                //File Display Classes
                if (cssclass === 'class_blue') {
                    var new_classc = 'class_white';
                } else {
                    var new_classc = 'class_blue';
                }


                if (typeof this.files[i] != undefined && this.files[i].name != "")
                {
                    //Check for the type of file browsed so as to represent each file with the appropriate file icon

                    if (file_to_add == "jpg" || file_to_add == "JPG" || file_to_add == "jpeg" || file_to_add == "JPEG" || file_to_add == "gif" || file_to_add == "GIF" || file_to_add == "png" || file_to_add == "PNG")
                    {
                        file_icon = '<img src="images/images_file.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "doc" || file_to_add == "docx" || file_to_add == "rtf" || file_to_add == "DOC" || file_to_add == "DOCX")
                    {
                        file_icon = '<img src="images/doc.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "pdf" || file_to_add == "PDF")
                    {
                        file_icon = '<img src="images/pdf.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "txt" || file_to_add == "TXT" || file_to_add == "RTF")
                    {
                        file_icon = '<img src="images/txt.png" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "php")
                    {
                        file_icon = '<img src="images/php.png" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "css")
                    {
                        file_icon = '<img src="images/general.png" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "js")
                    {
                        file_icon = '<img src="images/general.png" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "html" || file_to_add == "HTML" || file_to_add == "htm" || file_to_add == "HTM")
                    {
                        file_icon = '<img src="images/html.png" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "setup")
                    {
                        file_icon = '<img src="images/setup.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "video")
                    {
                        file_icon = '<img src="images/video.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "real")
                    {
                        file_icon = '<img src="images/real.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "psd")
                    {
                        file_icon = '<img src="images/psd.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "fla")
                    {
                        file_icon = '<img src="images/fla.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "xls")
                    {
                        file_icon = '<img src="images/xls.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "swf")
                    {
                        file_icon = '<img src="images/swf.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "eps")
                    {
                        file_icon = '<img src="images/eps.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "exe")
                    {
                        file_icon = '<img src="images/exe.gif" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "binary")
                    {
                        file_icon = '<img src="images/binary.png" align="absmiddle" border="0" alt="" />';
                    }
                    else if (file_to_add == "zip")
                    {
                        file_icon = '<img src="images/archive.png" align="absmiddle" border="0" alt="" />';
                    }
                    else
                    {
                        file_icon = '<img src="images/general.png" align="absmiddle" border="0" alt="" />';
                    }

                    //Assign browsed files to a variable so as to later display them below
                    added_files_displayer += '<div id="add_fileID' + file_id + '" align="left" class="' + new_classc + '" style=" margin-left:1px;"><div id="files_left" class="hove_this_link"><div style="width:360px; float:left;">' + file_icon + ' ' + this.files[i].name.substring(0, 40) + '</div><div style="width:90px; float:left;padding-top:2px;"><span id="uploading_' + file_id + '"><span class="ready">Pronto</span></span></div></div><div id="files_size_left">' + actual_fileSize + '</div><div id="files_time_left">' + date_last_modified_file + '</div><div id="files_remove_left"><span id="remove' + file_id + '"><span class="files_remove_left_inner" onclick="remove_this_file(\'' + file_id + '\',\'' + this.files[i].name + '\');">Remover</span></span></div><br clear="all" /></div>';

                }
            }
            //Display browsed files on the screen to the user who wants to upload them
            $("#arquivos_adicionados").append(added_files_displayer);
            $("#added_class").val(new_classc);
        }
    }

    //File Reader
    multiple_file_uploader.prototype.read_file = function(e) {
        if (e.target.files) {
            self.show_added_files(e.target.files);
            self.browsed_files.push(e.target.files);
        } else {
            alert('Desculpe, o arquivo especificado não pôde ser lido no momento.');
        }
    }


    function addEvent(type, el, fn) {
        if (window.addEventListener) {
            el.addEventListener(type, fn, false);
        } else if (window.attachEvent) {
            var f = function() {
                fn.call(el, window.event);
            };
            el.attachEvent('on' + type, f)
        }
    }


    //Get the ids of all added files and also start the upload when called
    multiple_file_uploader.prototype.starter = function() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            var browsed_file_ids = $("#" + this.settings.form_id).find("input[type='file']").eq(0).attr("id");
            document.getElementById(browsed_file_ids).addEventListener("change", this.read_file, false);
            document.getElementById(this.settings.form_id).addEventListener("submit", this.submit_added_files, true);
        }
        else {
            alert(msg);
        }
    }

    //Call the uploading function when click on the upload button
    multiple_file_uploader.prototype.submit_added_files = function() {
        self.upload_begin();
    }

    //Start uploads
    multiple_file_uploader.prototype.upload_begin = function() {
        if (this.browsed_files.length > 0) {
            for (var k = 0; k < this.browsed_files.length; k++) {
                var file = this.browsed_files[k];
                this.vasPLUS(file, 0);
            }
        }
    }

    //Main file uploader
    multiple_file_uploader.prototype.vasPLUS = function(file, file_counter)
    {
        if (typeof file[file_counter] != undefined && file[file_counter] != '')
        {
            //Use the file names without their extensions as their ids
            var files_name_without_extensions = file[file_counter].name.substr(0, file[file_counter].name.lastIndexOf('.')) || file[file_counter].name;
            var ids = files_name_without_extensions.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
            var browsed_file_ids = $("#" + this.settings.form_id).find("input[type='file']").eq(0).attr("id");

            var removed_file = $("#" + ids).val();

            if (removed_file != "" && removed_file != undefined && removed_file == ids)
            {
                self.vasPLUS(file, file_counter + 1);
            }
            else
            {
                var dataString = new FormData();
                dataString.append('upload_file', file[file_counter]);
                dataString.append('upload_file_ids', ids);
                //var arquivo =file[file_counter].lastModifiedDate; 
                dataString.append('last_modified', file[file_counter].lastModifiedDate);

                $.ajax({
                    type: "POST",
                    url: this.settings.server_url,
                    data: dataString,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function()
                    {
                        $("#uploading_" + ids).html('<div align="left"><img src="images/loadings.gif" align="absmiddle" title="Upload...."/></div>');
                        $("#remove" + ids).html('<div align="center" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:blue;">Enviado...</div>');
                    },
                    success: function(response)
                    {
                        setTimeout(function() {
                            var response_brought = response.indexOf(ids);
                            if (response_brought != -1) {
                                $("#uploading_" + ids).html('<div align="left" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:blue;">Completo</div>');
                                $("#remove" + ids).html('<div align="center" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:gray;">Enviado</div>');
                            } else {
                                var fileType_response_brought = response.indexOf('file_type_error');
                                if (fileType_response_brought != -1) {

                                    var filenamewithoutextension = response.replace('file_type_error&', '').substr(0, response.replace('file_type_error&', '').lastIndexOf('.')) || response.replace('file_type_error&', '');
                                    var fileID = filenamewithoutextension.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
                                    $("#uploading_" + fileID).html('<div align="left" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:red;">Arquivo inválido</div>');
                                    $("#remove" + fileID).html('<div align="center" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:orange;">Cancelado</div>');

                                } else {
                                    var filesize_response_brought = response.indexOf('file_size_error');
                                    if (filesize_response_brought != -1) {
                                        var filenamewithoutextensions = response.replace('file_size_error&', '').substr(0, response.replace('file_size_error&', '').lastIndexOf('.')) || response.replace('file_size_error&', '');
                                        var fileID = filenamewithoutextensions.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
                                        $("#uploading_" + fileID).html('<div align="left" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:red;">Tamanho excessivo</div>');
                                        $("#remove" + fileID).html('<div align="center" style="font-family:Verdana, Geneva, sans-serif;font-size:11px;color:orange;">Cancelado</div>');
                                    } else {
                                        var general_response_brought = response.indexOf('general_system_error');
                                        if (general_response_brought != -1) {
                                            alert('Desculpe, ocorreu um erro ao enviar o arquivo.');
                                        }
                                        else { /* Do nothing */
                                        }
                                    }
                                }
                            }
                            if (file_counter + 1 < file.length) {
                                self.vasPLUS(file, file_counter + 1);
                            }
                            else {
                            }
                        }, 2000);
                    }
                });
            }
        }
        else {
            alert('Desculpe o sistema não pôde verificar a identidade do arquivo que você está tentando enviar no momento.');
        }
    }
    this.starter();
}

function remove_this_file(id, filename)
{
    if (confirm('Deseja remover o arquivo? ' + filename + ''))
    {
        $("#arquivos_removidos").append('<input type="hidden" id="' + id + '" value="' + id + '">');
        $("#add_fileID" + id).slideUp();
    }
    return false;
}