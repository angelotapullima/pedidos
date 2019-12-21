function logoutSession(){
    document.location = 'util/system/logout.php';
}

$(document).ready(function (){
    var param_timeout = $("#param_timeout").val();

    setInterval(logoutSession, ( parseInt(param_timeout) * 60000 ));

    if( typeof Highcharts !== 'undefined' ){
        Highcharts.setOptions({
            lang: {
                printChart: "Imprimir",
                downloadCSV: 'Descargar CSV',
                downloadJPEG: 'Descargar imagen JPEG',
                downloadPDF: 'Descargar documento PDF',
                downloadPNG: 'Descargar imagen PNG',
                downloadSVG: 'Descargar imagen vectorial SVG',
                downloadXLS: 'Descargar XLS',
                viewFullscreen: 'Ver en pantalla completa',
                openInCloud: 'Abrir en Highcharts Cloud',
                viewData: 'ver tabla de datos'
            }
        });
    }

});