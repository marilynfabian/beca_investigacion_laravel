Dropzone.autoDiscover = false;

var pdfDropzone = new Dropzone("#pdfDropzone", {
    maxFilesize: 1,
    acceptedFiles: "application/pdf,.pdf",
    maxFiles: 1,
    addRemoveLinks: true,

    dictDefaultMessage: "Arrastra tu PDF aquí o haz clic para subirlo",
    dictRemoveFile: "Quitar archivo",
    dictInvalidFileType: "Solo se permite subir archivos PDF",
    dictFileTooBig: "El archivo no debe superar 1 MB",

    init: function () {
        this.on("success", function () {
            document
                .getElementById("uploadSuccessMessage")
                .classList
                .add("is-visible");
        });

        this.on("removedfile", function () {
            document
                .getElementById("uploadSuccessMessage")
                .classList
                .remove("is-visible");
        });

        this.on("error", function () {
            document
                .getElementById("uploadSuccessMessage")
                .classList
                .remove("is-visible");
        });
    }
});